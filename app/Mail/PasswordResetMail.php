<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * E-mail enviado quando o usuário solicita a recuperação de senha.
 * Contém o link para a tela de redefinição com token assinado.
 */
class PasswordResetMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public User $user, public string $resetUrl)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Recuperação de senha — Evidenciar',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.password-reset',
            with: [
                'user'     => $this->user,
                'resetUrl' => $this->resetUrl,
            ],
        );
    }
}
