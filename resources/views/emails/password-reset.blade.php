<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Recuperação de senha — Evidenciar</title>
</head>
<body style="margin:0;padding:0;background:#132d46;font-family:'Inter',Arial,Helvetica,sans-serif;color:#132d46;">
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#132d46;">
    <tr>
        <td align="center" style="padding:40px 16px;">
            <table width="600" cellpadding="0" cellspacing="0" border="0"
                   style="background:#ffffff;border-radius:14px;overflow:hidden;
                          box-shadow:0 10px 30px rgba(0,0,0,.25);">

                <!-- Header azul escuro com EVA -->
                <tr>
                    <td style="background:#132d46;color:#ffffff;padding:36px 32px;text-align:center;">
                        <img src="{{ asset('storage/icone-EVA.png') }}"
                             alt="EVA, assistente virtual da Evidenciar"
                             width="96" height="96"
                             style="display:block;margin:0 auto 12px;border-radius:50%;">
                        <h1 style="margin:0;font-size:24px;font-weight:700;color:#ffffff;">
                            Recuperação de senha
                        </h1>
                        <p style="margin:8px 0 0;font-size:15px;color:#edece1;opacity:.9;">
                            Recebemos um pedido para redefinir sua senha.
                        </p>
                    </td>
                </tr>

                <!-- Corpo -->
                <tr>
                    <td style="padding:36px 32px;">
                        <p style="margin:0 0 16px;font-size:16px;line-height:1.6;color:#132d46;">
                            Olá <strong>{{ $user->name }}</strong>,
                        </p>
                        <p style="margin:0 0 20px;font-size:15px;line-height:1.6;color:#132d46;">
                            Você (ou alguém) solicitou a redefinição da senha da sua conta na
                            <strong style="color:#267e87;">Evidenciar</strong>.
                            Clique no botão abaixo para escolher uma nova senha.
                        </p>

                        <!-- CTA verde -->
                        <div style="text-align:center;margin:28px 0;">
                            <a href="{{ $resetUrl }}"
                               style="background:#01c38e;color:#ffffff;text-decoration:none;
                                      padding:16px 32px;border-radius:10px;font-weight:600;
                                      display:inline-block;font-size:16px;">
                                Redefinir minha senha
                            </a>
                        </div>

                        <p style="margin:0 0 10px;font-size:13px;color:#6c7a89;line-height:1.6;">
                            Se o botão não funcionar, copie este link no seu navegador:
                        </p>
                        <p style="margin:0 0 24px;font-size:12px;color:#267e87;word-break:break-all;">
                            {{ $resetUrl }}
                        </p>

                        <hr style="border:none;border-top:1px solid rgba(19,45,70,.12);margin:24px 0;">

                        <!-- Aviso de validade / segurança -->
                        <table width="100%" cellpadding="0" cellspacing="0" border="0"
                               style="background:#f5f7fa;border:1px solid rgba(19,45,70,.08);
                                      border-radius:10px;margin-bottom:8px;">
                            <tr>
                                <td style="padding:16px 20px;font-size:13px;line-height:1.6;color:#132d46;">
                                    <strong style="color:#267e87;">Importante:</strong>
                                    este link expira em
                                    <strong>{{ config('auth.passwords.'.config('auth.defaults.passwords').'.expire', 60) }}&nbsp;minutos</strong>.
                                    Se você <em>não</em> solicitou a recuperação, pode ignorar este e-mail
                                    com segurança — sua senha atual continua ativa.
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <!-- Rodapé -->
                <tr>
                    <td style="padding:20px 32px;border-top:1px solid rgba(19,45,70,.12);
                               font-size:12px;color:#6c7a89;text-align:center;background:#fafbfc;">
                        Precisa de ajuda? Basta responder este e-mail e a nossa equipe vai te atender.
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
