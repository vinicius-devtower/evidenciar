<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Payment\PaymentClient;
use App\Models\Client;
use App\Models\CheckoutIntent;
use App\Models\Site;
use App\Models\User;
use App\Models\Subscription;
use App\Models\Payment;
use App\Models\ActivityLog;
use App\Models\TemplateVersion;
use App\Models\WebhookLog;
use App\Mail\WelcomeMail;

/**
 * Recebe notificações do Mercado Pago.
 *
 * Estratégia:
 *  - Sempre responde 200 (MP retenta se não responder rápido).
 *  - Para pagamentos aprovados, busca CheckoutIntent pelo external_id.
 *  - Materializa Client/User/Site/Subscription/Payment em transação.
 *  - Popula site.content com defaults do template (primeiro preview útil).
 *  - Envia WelcomeMail com link de primeiro acesso.
 */
class MercadoPagoWebhookController extends Controller
{
    public function handle(Request $request)
    {
        Log::info('MercadoPago Webhook recebido', $request->all());

        // Persiste todo webhook recebido (inclusive ignorados) para a tela
        // de Logs do Suporte. Falha silenciosamente se a tabela ainda não existir.
        try {
            WebhookLog::create([
                'provider'    => 'mercadopago',
                'event'       => (string) ($request->input('type') ?? 'unknown'),
                'payload'     => $request->all(),
                'received_at' => now(),
            ]);
        } catch (\Throwable $e) {
            Log::warning('Falha ao persistir WebhookLog: ' . $e->getMessage());
        }

        if (($request->type ?? null) !== 'payment') {
            return response()->json(['ignored' => true], 200);
        }

        $paymentId = $request->data['id'] ?? null;

        if (!$paymentId || $paymentId === '123456') {
            Log::info('Webhook de teste ignorado', ['payment_id' => $paymentId]);
            return response()->json(['ignored_test' => true], 200);
        }

        // Idempotência: se já processamos esse payment, não repete
        if (Payment::where('external_id', (string) $paymentId)->exists()) {
            return response()->json(['already_processed' => true], 200);
        }

        try {
            MercadoPagoConfig::setAccessToken(config('mercadopago.access_token'));
            $client = new PaymentClient();
            $payment = $client->get($paymentId);
        } catch (\Throwable $e) {
            Log::warning('Pagamento não encontrado no Mercado Pago', [
                'payment_id' => $paymentId,
                'error'      => $e->getMessage(),
            ]);
            return response()->json(['ignored' => true], 200);
        }

        if ($payment->status !== 'approved' || $payment->currency_id !== 'BRL') {
            return response()->json(['ignored_not_approved' => true, 'status' => $payment->status], 200);
        }

        try {
            $result = DB::transaction(fn () => $this->processApprovedPayment($payment));

            // Envia WelcomeMail com link para definir senha
            if (isset($result['user'])) {
                $this->sendWelcomeEmail($result['user']);
            }

            return response()->json(['success' => true], 200);
        } catch (\Throwable $e) {
            Log::error('Erro ao processar pagamento aprovado', [
                'payment_id' => $paymentId,
                'error'      => $e->getMessage(),
                'trace'      => $e->getTraceAsString(),
            ]);
            return response()->json(['handled_with_error' => true], 200);
        }
    }

    /**
     * Materializa os registros finais após pagamento aprovado.
     */
    protected function processApprovedPayment($payment): array
    {
        // 1) Busca o CheckoutIntent correspondente
        $intent = CheckoutIntent::where('external_id', (string) $payment->id)->first();

        // 2) Se não achou, tenta reconstruir pela external_reference (fallback)
        $metadata = [];
        if (!empty($payment->external_reference)) {
            $decoded = json_decode($payment->external_reference, true);
            if (is_array($decoded)) {
                $metadata = $decoded;
            }
        }

        if (!$intent && empty($metadata)) {
            throw new \Exception('CheckoutIntent não encontrado e external_reference vazia.');
        }

        $name          = $intent->name ?? $metadata['name'] ?? null;
        $email         = $intent->email ?? $metadata['email'] ?? null;
        $templateId    = $intent->template_id ?? $metadata['template_id'] ?? null;
        $documento     = $intent->documento ?? $metadata['documento'] ?? null;
        $planId        = $intent->plan_id ?? null;
        $paymentMethod = $intent->payment_method ?? 'pix';

        if (!$name || !$email || !$templateId) {
            throw new \Exception('Dados insuficientes para materializar o pagamento.');
        }

        // 3) Cria ou reusa Client (pelo email do user)
        $existingUser = User::where('email', $email)->first();
        if ($existingUser) {
            $client = $existingUser->client ?? Client::create(['name' => $name, 'status' => 'active']);
            if (!$existingUser->client_id) {
                $existingUser->update(['client_id' => $client->id]);
            }
            $user = $existingUser;
        } else {
            $client = Client::create([
                'name'     => $name,
                'document' => $documento,
                'status'   => 'active',
            ]);
            $user = User::create([
                'name'      => $name,
                'email'     => $email,
                'password'  => Hash::make(Str::random(32)),
                'client_id' => $client->id,
            ]);
        }

        // 4) Resolve TemplateVersion ativo
        $templateVersion = TemplateVersion::where('template_id', $templateId)
            ->where('is_active', true)
            ->firstOrFail();

        // 5) Cria Site com conteúdo default do template
        $defaultContent = $this->loadTemplateDefaults($templateVersion->path);

        $site = Site::create([
            'client_id'           => $client->id,
            'template_version_id' => $templateVersion->id,
            'name'                => $name . ' · Site',
            'slug'                => Str::slug($name) . '-' . Str::lower(Str::random(6)),
            'status'              => 'draft',
            'content'             => $defaultContent,
        ]);

        // 6) Subscription + Payment
        $subscription = Subscription::create([
            'client_id'      => $client->id,
            'site_id'        => $site->id,
            'plan_id'        => $planId,
            'payment_method' => $paymentMethod,
            'status'         => 'active',
            'started_at'     => now(),
        ]);

        Payment::create([
            'subscription_id' => $subscription->id,
            'provider'        => 'mercadopago',
            'external_id'     => (string) $payment->id,
            'amount'          => $payment->transaction_amount,
            'status'          => 'paid',
            'paid_at'         => $payment->date_approved ?? now(),
        ]);

        // 7) Marca o intent como approved
        if ($intent) {
            $intent->update(['status' => 'approved']);
        }

        ActivityLog::record(
            event:       'subscription.created',
            description: 'Assinatura criada após pagamento aprovado',
            subject:     $site,
            user:        $user
        );

        return compact('user', 'site', 'client');
    }

    /**
     * Lê o template.json e extrai os "default" de cada campo para
     * pré-popular o conteúdo inicial do site.
     */
    protected function loadTemplateDefaults(string $path): array
    {
        $jsonPath = resource_path("templates/{$path}/template.json");
        if (!File::exists($jsonPath)) {
            return [];
        }

        $config = json_decode(File::get($jsonPath), true);
        $content = [];

        foreach ($config['sections'] ?? [] as $section) {
            $sectionId = $section['id'];
            $content[$sectionId] = [];
            foreach ($section['fields'] ?? [] as $field) {
                if (array_key_exists('default', $field)) {
                    $content[$sectionId][$field['key']] = $field['default'];
                }
            }
        }

        return $content;
    }

    /**
     * Dispara e-mail de boas-vindas com link para definir senha.
     */
    protected function sendWelcomeEmail(User $user): void
    {
        try {
            // Gera um token "magic link" de reset de senha
            $token = Password::createToken($user);
            $resetUrl = url(route('password.reset', [
                'token' => $token,
                'email' => $user->email,
            ], false));

            Mail::to($user->email)->send(new WelcomeMail($user, $resetUrl));
        } catch (\Throwable $e) {
            Log::warning('Falha ao enviar WelcomeMail; caindo para sendResetLink padrão.', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
            ]);
            Password::sendResetLink(['email' => $user->email]);
        }
    }
}
