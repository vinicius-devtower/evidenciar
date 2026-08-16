<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Payment\PaymentClient;
use App\Models\Payment;
class MercadoPagoWebhookTestController extends Controller
{
    public function handle(Request $request)
    {
        Log::info('MercadoPago TEST Webhook recebido', $request->all());
        if (($request->type ?? null) !== 'payment') {
            return response()->json(['ignored' => true], 200);
        }
        $paymentId = $request->data['id'] ?? null;
        if (!$paymentId) {
            Log::warning('Webhook TEST sem payment ID');
            return response()->json(['ignored' => true], 200);
        }
        // Idempotência
        if (Payment::where('external_id', (string) $paymentId)->exists()) {
            return response()->json(['already_processed' => true], 200);
        }
        /*
        |--------------------------------------------------------------------------
        | Obter pagamento (fake para painel, real para sandbox)
        |--------------------------------------------------------------------------
        */
        try {
            if ($paymentId === '123456') {
                Log::info('Pagamento simulado via painel Mercado Pago');
                $payment = (object) [
                    'id' => 'panel-test-' . Str::uuid(),
                    'status' => 'approved',
                    'currency_id' => 'BRL',
                    'transaction_amount' => 49.00,
                    'approved_at' => now(),
                    'external_reference' => json_encode([
                        'template_id' => 1,
                        'name' => 'Cliente Teste',
                        'email' => 'vinicius@devtower.com.br',
                    ]),
                    'metadata' => [],
                ];
            } else {
                MercadoPagoConfig::setAccessToken(config('mercadopago.access_token'));
                $client = new PaymentClient();
                $payment = $client->get($paymentId);
            }
        } catch (\Throwable $e) {
            Log::warning('Erro ao obter pagamento (TEST)', [
                'payment_id' => $paymentId,
                'error' => $e->getMessage(),
            ]);
            return response()->json(['ignored' => true], 200);
        }
        // Validação comum (real ou teste)
        if (
            $payment->status !== 'approved' ||
            $payment->currency_id !== 'BRL' ||
            (float) $payment->transaction_amount !== 49.00
        ) {
            return response()->json(['ignored' => true], 200);
        }
        /*
        |--------------------------------------------------------------------------
        | Fluxo único: salvar + enviar e-mail
        |--------------------------------------------------------------------------
        */
        try {
            $result = DB::transaction(function () use ($payment) {
                return app(MercadoPagoWebhookController::class)
                    ->processApprovedPayment($payment);
            });
            if (!empty($result['user'])) {
                Password::sendResetLink([
                    'email' => $result['user']->email,
                ]);
            }
            return response()->json(['success' => true], 200);
        } catch (\Throwable $e) {
            Log::error('Erro no fluxo pós-pagamento (TEST)', [
                'payment_id' => $paymentId,
                'error' => $e->getMessage(),
            ]);
            return response()->json(['handled_with_error' => true], 200);
        }
    }
}
