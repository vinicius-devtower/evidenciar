<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Bem-vindo(a) à Evidenciar</title>
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
                            Pagamento confirmado!
                        </h1>
                        <p style="margin:8px 0 0;font-size:15px;color:#edece1;opacity:.9;">
                            Seu acesso à Evidenciar está pronto.
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
                            Este é o seu primeiro acesso. Para começar, clique abaixo
                            e defina sua senha — ela será usada a partir de agora para
                            entrar no painel e gerenciar o seu site.
                        </p>

                        <!-- CTA verde -->
                        <div style="text-align:center;margin:28px 0;">
                            <a href="{{ $accessUrl }}"
                               style="background:#01c38e;color:#ffffff;text-decoration:none;
                                      padding:16px 32px;border-radius:10px;font-weight:600;
                                      display:inline-block;font-size:16px;">
                                Definir minha senha
                            </a>
                        </div>

                        <p style="margin:0 0 10px;font-size:13px;color:#6c7a89;line-height:1.6;">
                            Se o botão não funcionar, copie este link no seu navegador:
                        </p>
                        <p style="margin:0 0 24px;font-size:12px;color:#267e87;word-break:break-all;">
                            {{ $accessUrl }}
                        </p>

                        <hr style="border:none;border-top:1px solid rgba(19,45,70,.12);margin:24px 0;">

                        <!-- Passo a passo -->
                        <p style="margin:0 0 12px;font-size:14px;font-weight:700;color:#132d46;">
                            O que vem a seguir
                        </p>

                        <table width="100%" cellpadding="0" cellspacing="0" border="0"
                               style="font-size:14px;line-height:1.6;color:#132d46;">
                            <tr>
                                <td width="28" valign="top"
                                    style="color:#01c38e;font-weight:700;">1.</td>
                                <td>Defina sua senha de acesso.</td>
                            </tr>
                            <tr>
                                <td width="28" valign="top"
                                    style="color:#01c38e;font-weight:700;">2.</td>
                                <td>Escolha um template para o seu site.</td>
                            </tr>
                            <tr>
                                <td width="28" valign="top"
                                    style="color:#01c38e;font-weight:700;">3.</td>
                                <td>Use a aba <strong style="color:#267e87;">Editor do Site</strong>
                                    para editar as seções na barra lateral.</td>
                            </tr>
                            <tr>
                                <td width="28" valign="top"
                                    style="color:#01c38e;font-weight:700;">4.</td>
                                <td>Clique em <strong>Salvar</strong> e solicite a publicação
                                    quando estiver pronto.</td>
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
