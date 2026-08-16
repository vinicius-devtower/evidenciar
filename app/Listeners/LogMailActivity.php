<?php

namespace App\Listeners;

use App\Models\EmailLog;
use Illuminate\Mail\Events\MessageSending;
use Illuminate\Mail\Events\MessageSent;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\Mime\Email;
use Throwable;

/**
 * Captura ciclo de vida de cada e-mail enviado pela app:
 *  - MessageSending cria registro com status=sending
 *  - MessageSent marca como sent + sent_at
 *
 * Correlacionamos via header customizado X-EmailLog-Id injetado no
 * envelope durante o MessageSending. Isso funciona mesmo quando não
 * há campo 'to' único (cc/bcc) porque o header chega intacto no MessageSent.
 */
class LogMailActivity
{
    public function handleSending(MessageSending $event): void
    {
        if (!Schema::hasTable('email_logs')) {
            return;
        }

        try {
            $message = $event->message;

            $to = $this->primaryRecipient($message);
            $subject = (string) $message->getSubject();

            $record = EmailLog::create([
                'to'             => $to,
                'subject'        => mb_substr($subject, 0, 250),
                'mailable_class' => $event->data['__laravel_notification'] ?? $this->guessMailable($event->data),
                'status'         => 'sending',
                'meta'           => $this->sanitizeMeta($event->data),
            ]);

            // Marca o message para correlacionar no MessageSent.
            $message->getHeaders()->addTextHeader('X-EmailLog-Id', (string) $record->id);
        } catch (Throwable $e) {
            Log::warning('Falha ao registrar EmailLog (sending): ' . $e->getMessage());
        }
    }

    public function handleSent(MessageSent $event): void
    {
        if (!Schema::hasTable('email_logs')) {
            return;
        }

        try {
            $headers = $event->message->getHeaders();
            $logId = $headers->get('X-EmailLog-Id')?->getBodyAsString();

            if (!$logId) {
                return;
            }

            EmailLog::where('id', (int) $logId)->update([
                'status'  => 'sent',
                'sent_at' => now(),
            ]);
        } catch (Throwable $e) {
            Log::warning('Falha ao registrar EmailLog (sent): ' . $e->getMessage());
        }
    }

    protected function primaryRecipient(Email $message): string
    {
        $to = $message->getTo();
        if (!empty($to)) {
            return $to[0]->getAddress();
        }

        $cc = $message->getCc();
        if (!empty($cc)) {
            return $cc[0]->getAddress();
        }

        return 'desconhecido';
    }

    /**
     * Tenta descobrir a classe do Mailable a partir do $data injetado
     * pelo framework. Laravel 9 inclui 'message' com o Mailable instance
     * quando for Mail::to(...)->send(new X).
     */
    protected function guessMailable(array $data): ?string
    {
        foreach ($data as $value) {
            if (is_object($value) && str_contains(get_class($value), '\\Mail\\')) {
                return get_class($value);
            }
        }
        return null;
    }

    /**
     * Remove do meta objetos não serializáveis (como a própria instância Mailable)
     * e campos sensíveis.
     */
    protected function sanitizeMeta(array $data): array
    {
        $safe = [];
        foreach ($data as $key => $value) {
            if (is_scalar($value) || is_null($value)) {
                if (in_array(strtolower((string) $key), ['password', 'token', 'secret', 'pix_code'], true)) {
                    continue;
                }
                $safe[$key] = $value;
            } elseif (is_array($value)) {
                $safe[$key] = '[array]';
            } else {
                $safe[$key] = is_object($value) ? '[' . get_class($value) . ']' : '[unserializable]';
            }
        }
        return $safe;
    }
}
