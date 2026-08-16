<?php

namespace App\Services;

use App\Models\IntegrationSetting;

/**
 * Fonte única de verdade pras credenciais do Mercado Pago em runtime.
 *
 * Prioridade: linha `integration_settings` (provider=mercadopago, editável
 * em /dev/integracoes/mercadopago) > .env. Isso permite trocar credencial
 * pelo painel sem precisar de novo deploy, mas nenhum ambiente quebra se a
 * tela nunca foi preenchida — cai pro .env como sempre funcionou.
 */
class MercadoPagoSettings
{
    protected static ?IntegrationSetting $cached = null;
    protected static bool $loaded = false;

    protected static function row(): ?IntegrationSetting
    {
        if (!static::$loaded) {
            static::$cached = IntegrationSetting::where('provider', 'mercadopago')->first();
            static::$loaded = true;
        }

        return static::$cached;
    }

    protected static function pick(?string $dbValue, string $envKey): ?string
    {
        return filled($dbValue) ? $dbValue : config($envKey);
    }

    public static function publicKey(): ?string
    {
        return static::pick(static::row()?->public_key, 'mercadopago.public_key');
    }

    public static function accessToken(): ?string
    {
        return static::pick(static::row()?->access_token, 'mercadopago.access_token');
    }

    public static function clientId(): ?string
    {
        return static::row()?->client_id;
    }

    public static function clientSecret(): ?string
    {
        return static::row()?->client_secret;
    }

    public static function webhookSecret(): ?string
    {
        return static::pick(static::row()?->webhook_secret, 'mercadopago.webhook_secret');
    }

    public static function notificationUrl(): ?string
    {
        return static::row()?->notification_url;
    }
}
