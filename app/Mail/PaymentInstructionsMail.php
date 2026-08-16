<?php

namespace App\Mail;

use App\Models\CheckoutIntent;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * E-mail enviado ao cliente logo após a geração do PIX,
 * com QR Code (em anexo), código copia-e-cola e link para
 * a tela de "aguardando pagamento".
 */
class PaymentInstructionsMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public CheckoutIntent $intent)
    {
    }

    public function envelope(): Envelope
    {
        $subject = $this->intent->isBoleto()
            ? 'Seu boleto está pronto — Evidenciar'
            : 'Seu PIX está pronto — Evidenciar';

        return new Envelope(subject: $subject);
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.payment-instructions',
            with: [
                'intent'        => $this->intent,
                'amountFormatted' => number_format((float) $this->intent->amount, 2, ',', '.'),
                'awaitingUrl'   => route('checkout.awaiting', $this->intent),
            ],
        );
    }

    /**
     * Anexa o QR Code como imagem embedada (inline via CID)
     * permitindo que o template referencie via cid:pix-qr.
     */
    public function attachments(): array
    {
        if (!$this->intent->qr_code_base64) {
            return [];
        }

        return [
            \Illuminate\Mail\Mailables\Attachment::fromData(
                fn () => base64_decode($this->intent->qr_code_base64),
                'pix-qr.png'
            )->withMime('image/png')->as('pix-qr.png'),
        ];
    }
}
