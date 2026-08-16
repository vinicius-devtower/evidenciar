<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * E-mail enviado após pagamento confirmado, contendo o
 * link mágico para o usuário definir sua senha e acessar o painel.
 */
class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public User $user, public string $accessUrl)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Seu acesso está pronto — Evidenciar',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.welcome',
            with: [
                'user'      => $this->user,
                'accessUrl' => $this->accessUrl,
            ],
        );
    }
}
