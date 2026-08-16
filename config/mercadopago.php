<?php

return [
    'access_token'   => env('MP_ACCESS_TOKEN'),
    'public_key'     => env('MP_PUBLIC_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Webhook signing secret
    |--------------------------------------------------------------------------
    |
    | Chave secreta usada pelo Mercado Pago para assinar os webhooks
    | (HMAC-SHA256). Configure em:
    |
    |   https://www.mercadopago.com.br/developers/panel/app/<APP_ID>/webhooks
    |
    | Copie a "Chave secreta" e coloque em MP_WEBHOOK_SECRET no .env.
    |
    | Se vier vazio, a validação é desligada (útil em dev).
    | Em produção, NUNCA deixe vazio.
    |
    */
    'webhook_secret' => env('MP_WEBHOOK_SECRET'),

    /*
    |--------------------------------------------------------------------------
    | Tolerância de timestamp (segundos)
    |--------------------------------------------------------------------------
    |
    | Janela máxima entre o `ts` do header x-signature e o agora. Protege
    | contra ataques de replay. MP raramente atrasa mais que 60s; 300s
    | (5 minutos) é um bom padrão e absorve pequenos drifts de relógio.
    |
    */
    'webhook_max_age' => (int) env('MP_WEBHOOK_MAX_AGE', 300),
];
