<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Models\CheckoutIntent;
use App\Models\Plan;
use App\Models\Template;
use App\Mail\PaymentInstructionsMail;
use App\Services\MercadoPagoSettings;
use Illuminate\Support\Str;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\Client\Common\RequestOptions;
use MercadoPago\Exceptions\MPApiException;

/**
 * CheckoutController — cria cobranças via Mercado Pago (PIX, Boleto ou Cartão).
 *
 * Fluxo:
 *   1. Jornada coleta todos os dados do cliente em session().
 *   2. JornadaController@saveStep3 -> redirect("checkout.create").
 *   3. Este controller consolida session + plano + gera o pagamento certo.
 *   4. Cria CheckoutIntent pendente/approved, dispara e-mail de instruções.
 *   5. Redireciona para tela de "aguardando pagamento" (ou success, p/ cartão aprovado).
 *   6. Webhook do MP materializa Client/User/Site/Subscription/Payment.
 */
class CheckoutController extends Controller
{
    protected const SESSION_KEY = 'jornada';

    /**
     * Fallback legacy: alguém chega em /checkout/{template} -> vai pra jornada.
     */
    public function show(Template $template)
    {
        return redirect()->route('jornada.start', ['template' => $template->slug]);
    }

    /**
     * Cria o pagamento (PIX/Boleto/Cartão) a partir dos dados coletados na jornada.
     */
    public function create(Request $request)
    {
        $journey = Session::get(self::SESSION_KEY, []);

        foreach (['step1', 'step2', 'step3'] as $step) {
            if (empty($journey[$step])) {
                return redirect()->route('jornada.start')
                    ->with('warning', 'Sessão expirada. Vamos começar de novo.');
            }
        }

        $step3 = $journey['step3'];
        $method = $step3['payment_method'] ?? CheckoutIntent::METHOD_PIX;

        // Plano escolhido na LP — obrigatório para determinar o preço.
        $planId = $journey['plan_id'] ?? null;
        $plan   = $planId ? Plan::find($planId) : null;
        if (!$plan) {
            return redirect('/#pricing')
                ->with('warning', 'Escolha um plano para continuar.');
        }
        $amount = $plan->price_cents / 100;

        $templateId = $journey['template_id']
            ?? optional(Template::where('status', 'active')->first())->id;
        if (!$templateId) {
            abort(500, 'Nenhum template ativo configurado.');
        }

        // Cria pagamento no MP conforme o método
        try {
            $mpPayment = match ($method) {
                CheckoutIntent::METHOD_PIX    => $this->createPixPayment($step3, $templateId, $amount, $plan),
                CheckoutIntent::METHOD_BOLETO => $this->createBoletoPayment($step3, $templateId, $amount, $plan),
                CheckoutIntent::METHOD_CARD   => $this->createCardPayment($step3, $templateId, $amount, $plan),
                default                       => throw new \InvalidArgumentException("Método de pagamento inválido: {$method}"),
            };
        } catch (MPApiException $e) {
            $apiBody = $e->getApiResponse()?->getContent();
            Log::error('Erro MP ao criar pagamento', [
                'method'   => $method,
                'message'  => $e->getMessage(),
                'status'   => $e->getApiResponse()?->getStatusCode(),
                'response' => $apiBody,
            ]);
            $detail = is_array($apiBody) ? ($apiBody['message'] ?? null) : null;
            if (!$detail && is_array($apiBody) && !empty($apiBody['cause'][0]['description'])) {
                $detail = $apiBody['cause'][0]['description'];
            }
            return redirect()->back()
                ->withErrors(['mp' => 'Mercado Pago recusou o pagamento: ' . ($detail ?: 'tente novamente em instantes.')])
                ->withInput();
        } catch (\Throwable $e) {
            Log::error('Erro genérico ao criar pagamento', [
                'method' => $method,
                'error'  => $e->getMessage(),
                'trace'  => $e->getTraceAsString(),
            ]);
            return redirect()->back()
                ->withErrors(['mp' => 'Erro ao gerar pagamento: ' . $e->getMessage()])
                ->withInput();
        }

        // Extrai dados específicos por método
        $transactionData = $mpPayment->point_of_interaction->transaction_data ?? null;
        $qrCode         = $transactionData->qr_code ?? null;
        $qrCodeBase64   = $transactionData->qr_code_base64 ?? null;
        $boletoUrl      = $transactionData->ticket_url ?? null;
        $boletoLine     = $transactionData->barcode->content ?? null;

        $initialStatus = match ($mpPayment->status ?? 'pending') {
            'approved'           => 'approved',
            'rejected','cancelled' => 'failed',
            default              => 'pending',
        };

        $intent = CheckoutIntent::create([
            'template_id'    => $templateId,
            'plan_id'        => $plan->id,
            'external_id'    => (string) $mpPayment->id,
            'name'           => $step3['name'],
            'email'          => $step3['email'],
            'whatsapp'       => $step3['whatsapp'] ?? null,
            'documento'      => $step3['documento'] ?? null,
            'amount'         => $amount,
            'payment_method' => $method,
            'qr_code'        => $qrCode,
            'qr_code_base64' => $qrCodeBase64,
            'boleto_url'     => $boletoUrl,
            'boleto_line'    => $boletoLine,
            'card_last4'     => $method === CheckoutIntent::METHOD_CARD ? ($step3['card_last4'] ?? null) : null,
            'card_brand'     => $method === CheckoutIntent::METHOD_CARD ? ($step3['card_brand'] ?? null) : null,
            'installments'   => $method === CheckoutIntent::METHOD_CARD ? ($step3['installments'] ?? null) : null,
            'journey_data'   => $journey,
            'expires_at'     => $mpPayment->date_of_expiration ?? now()->addDays($method === CheckoutIntent::METHOD_BOLETO ? 3 : 1),
            'status'         => $initialStatus,
        ]);

        // Dispara e-mail com as instruções (apenas para fluxos que exigem ação)
        if (in_array($method, [CheckoutIntent::METHOD_PIX, CheckoutIntent::METHOD_BOLETO], true)) {
            try {
                Mail::to($intent->email)->send(new PaymentInstructionsMail($intent));
            } catch (\Throwable $e) {
                Log::warning('Falha ao enviar e-mail de instruções de pagamento', [
                    'intent_id' => $intent->id,
                    'method'    => $method,
                    'error'     => $e->getMessage(),
                ]);
            }
        }

        Session::forget(self::SESSION_KEY);

        // Cartão aprovado na hora => success. Caso contrário, aguarda confirmação.
        if ($method === CheckoutIntent::METHOD_CARD && $initialStatus === 'approved') {
            return redirect()->route('checkout.success');
        }

        return redirect()->route('checkout.awaiting', $intent);
    }

    /**
     * Tela com QR Code PIX / boleto / status do cartão. Auto-refresh até confirmar.
     */
    public function awaiting(CheckoutIntent $intent)
    {
        if ($intent->status === 'approved') {
            return redirect()->route('checkout.success');
        }

        return view('jornada.aguardando-pagamento', [
            'payment' => $intent,
        ]);
    }

    // =================================================================
    // Montagem de payloads específicos por método
    // =================================================================

    protected function createPixPayment(array $step3, int $templateId, float $amount, Plan $plan)
    {
        $client = $this->mpPaymentClient();
        $payload = $this->baseMpPayload($step3, $templateId, $amount, $plan);
        $payload['payment_method_id'] = 'pix';
        $payload['date_of_expiration'] = now()->addMinutes(30)->format('Y-m-d\TH:i:s.vP');

        return $client->create($payload, $this->idempotencyOptions());
    }

    protected function createBoletoPayment(array $step3, int $templateId, float $amount, Plan $plan)
    {
        $client = $this->mpPaymentClient();
        $payload = $this->baseMpPayload($step3, $templateId, $amount, $plan);
        $payload['payment_method_id'] = 'bolbradesco';
        $payload['date_of_expiration'] = now()->addDays(3)->format('Y-m-d\TH:i:s.vP');

        // Boleto exige endereço do pagador — passamos placeholders mínimos;
        // o usuário pode complementar depois no checkout MP se necessário.
        $payload['payer']['address'] = [
            'zip_code'      => '01310-100',
            'street_name'   => 'Endereço a confirmar',
            'street_number' => '0',
            'neighborhood'  => 'Centro',
            'city'          => 'São Paulo',
            'federal_unit'  => 'SP',
        ];

        return $client->create($payload, $this->idempotencyOptions());
    }

    protected function createCardPayment(array $step3, int $templateId, float $amount, Plan $plan)
    {
        if (empty($step3['card_token'])) {
            throw new \InvalidArgumentException('Token do cartão ausente.');
        }

        $client = $this->mpPaymentClient();
        $payload = $this->baseMpPayload($step3, $templateId, $amount, $plan);
        $payload['token']             = $step3['card_token'];
        $payload['installments']      = (int) ($step3['installments'] ?? 1);
        $payload['payment_method_id'] = strtolower((string) ($step3['card_brand'] ?? 'visa'));
        $payload['statement_descriptor'] = 'EVIDENCIAR';

        return $client->create($payload, $this->idempotencyOptions());
    }

    // =================================================================
    // Helpers MP
    // =================================================================

    protected function mpPaymentClient(): PaymentClient
    {
        $accessToken = MercadoPagoSettings::accessToken();
        if (empty($accessToken)) {
            throw new \RuntimeException('Access Token do Mercado Pago não configurado (nem em /dev/integracoes/mercadopago, nem em MP_ACCESS_TOKEN no .env).');
        }
        MercadoPagoConfig::setAccessToken($accessToken);
        return new PaymentClient();
    }

    protected function idempotencyOptions(): RequestOptions
    {
        $opts = new RequestOptions();
        $opts->setCustomHeaders([
            'X-Idempotency-Key: ' . (string) Str::uuid(),
        ]);
        return $opts;
    }

    /**
     * Campos comuns a todos os métodos de pagamento (payer, descrição, etc).
     */
    protected function baseMpPayload(array $step3, int $templateId, float $amount, Plan $plan): array
    {
        [$firstName, $lastName] = $this->splitName($step3['name']);
        $documento = preg_replace('/\D/', '', $step3['documento'] ?? '');

        $payer = [
            'email'      => $step3['email'],
            'first_name' => $firstName,
            'last_name'  => $lastName,
        ];
        if (in_array(strlen($documento), [11, 14], true)) {
            $payer['identification'] = [
                'type'   => strlen($documento) === 11 ? 'CPF' : 'CNPJ',
                'number' => $documento,
            ];
        }

        $externalRef = "tpl:{$templateId}|plan:{$plan->slug}|email:{$step3['email']}";

        $payload = [
            'transaction_amount' => (float) $amount,
            'description'        => "Evidenciar — Plano {$plan->name}",
            'payer'              => $payer,
            'external_reference' => $externalRef,
        ];

        $notificationUrl = route('webhooks.mercadopago');
        if (Str::startsWith($notificationUrl, 'https://')) {
            $payload['notification_url'] = $notificationUrl;
        }

        return $payload;
    }

    protected function splitName(string $full): array
    {
        $parts = preg_split('/\s+/', trim($full));
        $first = array_shift($parts) ?? '';
        $last  = implode(' ', $parts) ?: $first;
        return [$first, $last];
    }
}
