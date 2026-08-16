<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Instruções de pagamento — Evidenciar</title>
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
                            @if($intent->isBoleto())
                                Seu boleto foi gerado!
                            @else
                                Seu PIX está pronto!
                            @endif
                        </h1>
                        <p style="margin:8px 0 0;font-size:15px;color:#edece1;opacity:.9;">
                            Olá {{ $intent->name }}, obrigado por iniciar sua assinatura.
                        </p>
                    </td>
                </tr>

                <!-- Corpo -->
                <tr>
                    <td style="padding:36px 32px;">
                        <p style="margin:0 0 20px;font-size:15px;line-height:1.6;color:#132d46;">
                            @if($intent->isBoleto())
                                Para ativar seu site, basta pagar o boleto abaixo.
                                Lembre-se: a compensação bancária pode levar até 2 dias úteis.
                            @else
                                Para ativar seu site, basta pagar o PIX abaixo.
                                Assim que o pagamento for confirmado, você recebe um novo e-mail com
                                o link para <strong>definir sua senha</strong>.
                            @endif
                        </p>

                        <!-- Valor + expira -->
                        <table width="100%" cellpadding="0" cellspacing="0" border="0"
                               style="background:#f5f7fa;border:1px solid rgba(19,45,70,.08);
                                      border-radius:12px;margin-bottom:24px;">
                            <tr>
                                <td style="padding:18px 20px;" width="50%">
                                    <p style="margin:0 0 6px;font-size:12px;color:#6c7a89;
                                              text-transform:uppercase;letter-spacing:1px;font-weight:600;">Valor</p>
                                    <p style="margin:0;font-size:22px;font-weight:700;color:#132d46;">
                                        R$ {{ $amountFormatted }}
                                    </p>
                                </td>
                                <td style="padding:18px 20px;border-left:1px solid rgba(19,45,70,.08);" width="50%">
                                    <p style="margin:0 0 6px;font-size:12px;color:#6c7a89;
                                              text-transform:uppercase;letter-spacing:1px;font-weight:600;">Expira em</p>
                                    <p style="margin:0;font-size:15px;font-weight:600;color:#132d46;">
                                        @if($intent->expires_at)
                                            {{ $intent->expires_at->format('d/m/Y H:i') }}
                                        @else
                                            30 minutos
                                        @endif
                                    </p>
                                </td>
                            </tr>
                        </table>

                        @if($intent->isPix())
                            @if($intent->qr_code_base64)
                                <div style="text-align:center;margin-bottom:24px;">
                                    <img src="data:image/png;base64,{{ $intent->qr_code_base64 }}"
                                         alt="QR Code PIX"
                                         width="220" height="220"
                                         style="border:1px solid rgba(19,45,70,.08);border-radius:10px;
                                                padding:8px;background:#fff;">
                                    <p style="margin:12px 0 0;font-size:13px;color:#6c7a89;">
                                        Escaneie com o app do seu banco
                                    </p>
                                </div>
                            @endif

                            @if($intent->qr_code)
                                <p style="margin:0 0 10px;font-size:13px;color:#132d46;font-weight:600;">
                                    Ou copie o código PIX:
                                </p>
                                <div style="background:#132d46;color:#edece1;padding:14px 16px;border-radius:10px;
                                            font-family:'Courier New',monospace;font-size:12px;
                                            word-break:break-all;line-height:1.5;">
                                    {{ $intent->qr_code }}
                                </div>
                            @endif
                        @elseif($intent->isBoleto())
                            @if($intent->boleto_line)
                                <p style="margin:0 0 10px;font-size:13px;color:#132d46;font-weight:600;">
                                    Linha digitável:
                                </p>
                                <div style="background:#132d46;color:#edece1;padding:14px 16px;border-radius:10px;
                                            font-family:'Courier New',monospace;font-size:13px;
                                            word-break:break-all;line-height:1.5;margin-bottom:20px;">
                                    {{ $intent->boleto_line }}
                                </div>
                            @endif
                            @if($intent->boleto_url)
                                <div style="text-align:center;margin:0 0 12px;">
                                    <a href="{{ $intent->boleto_url }}"
                                       style="background:#267e87;color:#ffffff;text-decoration:none;
                                              padding:12px 24px;border-radius:10px;font-weight:600;
                                              display:inline-block;font-size:14px;">
                                        Abrir boleto em PDF ↗
                                    </a>
                                </div>
                            @endif
                        @endif

                        <!-- CTA verde -->
                        <div style="text-align:center;margin:28px 0 8px;">
                            <a href="{{ $awaitingUrl }}"
                               style="background:#01c38e;color:#ffffff;text-decoration:none;
                                      padding:14px 28px;border-radius:10px;font-weight:600;
                                      display:inline-block;font-size:15px;">
                                Ver status do pagamento
                            </a>
                        </div>

                        <hr style="border:none;border-top:1px solid rgba(19,45,70,.12);margin:28px 0 20px;">

                        <p style="margin:0;font-size:13px;color:#6c7a89;line-height:1.6;">
                            Assim que identificarmos seu pagamento, você receberá um segundo e-mail
                            com o link para <strong style="color:#267e87;">criar sua senha</strong>
                            e acessar a plataforma.
                        </p>
                    </td>
                </tr>

                <!-- Rodapé -->
                <tr>
                    <td style="padding:20px 32px;border-top:1px solid rgba(19,45,70,.12);
                               font-size:12px;color:#6c7a89;text-align:center;background:#fafbfc;">
                        ID do pagamento: <code style="color:#267e87;">{{ $intent->external_id }}</code><br>
                        Dúvidas? Basta responder este e-mail e a nossa equipe vai te atender.
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
