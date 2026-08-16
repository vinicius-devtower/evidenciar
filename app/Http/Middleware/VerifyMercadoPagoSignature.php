<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\MercadoPagoSettings;
use Symfony\Component\HttpFoundation\Response;

/**
 * Valida a assinatura HMAC-SHA256 enviada pelo Mercado Pago
 * no header `x-signature`.
 *
 * Documentação oficial:
 *   https://www.mercadopago.com.br/developers/pt/docs/your-integrations/notifications/webhooks#signature-validation
 *
 * Cadeia de assinatura (string template):
 *   id:[data.id];request-id:[x-request-id];ts:[ts];
 *
 * O MP assina essa string com a `Chave secreta` configurada no painel
 * do Webhook. Calculamos o HMAC-SHA256 e comparamos em timing-safe
 * com o valor `v1=...` do header `x-signature`.
 */
class VerifyMercadoPagoSignature
{
    public function handle(Request $request, Closure $next): Response
    {
        $secret = MercadoPagoSettings::webhookSecret();

        // Se não configurou o secret, a validação é pulada (dev).
        // Em produção o deploy DEVE preencher MP_WEBHOOK_SECRET.
        if (empty($secret)) {
            if (app()->environment('production')) {
                Log::warning('MP webhook recebido em produção sem MP_WEBHOOK_SECRET configurado.');
            }
            return $next($request);
        }

        $signatureHeader = $request->header('x-signature');
        $requestId       = $request->header('x-request-id');

        if (!$signatureHeader) {
            return $this->reject('missing_signature_header');
        }

        // Parse "ts=1704908010,v1=abc123..."
        $parts = [];
        foreach (explode(',', $signatureHeader) as $chunk) {
            if (!str_contains($chunk, '=')) {
                continue;
            }
            [$k, $v] = array_map('trim', explode('=', $chunk, 2));
            $parts[$k] = $v;
        }

        $ts = $parts['ts']  ?? null;
        $v1 = $parts['v1']  ?? null;

        if (!$ts || !$v1) {
            return $this->reject('malformed_signature_header', ['header' => $signatureHeader]);
        }

        // Anti-replay: ts deve estar dentro da janela de tolerância.
        $maxAge = (int) config('mercadopago.webhook_max_age', 300);
        if (abs(time() - (int) $ts) > $maxAge) {
            return $this->reject('expired_timestamp', ['ts' => $ts, 'now' => time()]);
        }

        // O `id` vem do corpo JSON (data.id). Não bate com $request->path().
        $dataId = $request->input('data.id');

        // Webhook de teste do painel do MP envia data.id "123456" sem
        // assinatura real — deixamos passar pra facilitar o "Enviar teste"
        // do painel; o controller já ignora esses IDs de teste.
        if ((string) $dataId === '123456') {
            return $next($request);
        }

        if ($dataId === null) {
            return $this->reject('missing_data_id');
        }

        $template = "id:{$dataId};request-id:{$requestId};ts:{$ts};";
        $expected = hash_hmac('sha256', $template, $secret);

        if (!hash_equals($expected, $v1)) {
            return $this->reject('signature_mismatch', [
                'expected' => substr($expected, 0, 8) . '…',
                'received' => substr($v1, 0, 8) . '…',
            ]);
        }

        return $next($request);
    }

    protected function reject(string $reason, array $ctx = []): Response
    {
        Log::warning('MP webhook rejeitado', array_merge(['reason' => $reason], $ctx));
        return response()->json(['error' => 'invalid_signature', 'reason' => $reason], 401);
    }
}
