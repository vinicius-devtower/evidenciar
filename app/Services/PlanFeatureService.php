<?php

namespace App\Services;

use App\Models\Client;
use App\Models\User;

/**
 * Central para todas as decisões de "este usuário tem direito a X?".
 *
 * Uso típico:
 *   app(PlanFeatureService::class)->userHas($user, 'eva')
 *   app(PlanFeatureService::class)->clientHas($client, 'blog')
 *
 * Admins/suporte/finance/dev ignoram o gating — eles enxergam tudo
 * independentemente do plano do cliente impersonado.
 */
class PlanFeatureService
{
    /** Features conhecidas — útil para enums em views/forms. */
    public const FEATURE_EVA              = 'eva';
    public const FEATURE_MULTIPAGE        = 'multipage';
    public const FEATURE_BLOG             = 'blog';
    public const FEATURE_PRO_EMAIL        = 'pro_email';
    public const FEATURE_PRIORITY_SUPPORT = 'priority_support';
    public const FEATURE_VIP_SUPPORT      = 'vip_support';

    public const ALL_FEATURES = [
        self::FEATURE_EVA,
        self::FEATURE_MULTIPAGE,
        self::FEATURE_BLOG,
        self::FEATURE_PRO_EMAIL,
        self::FEATURE_PRIORITY_SUPPORT,
        self::FEATURE_VIP_SUPPORT,
    ];

    public function userHas(?User $user, string $feature): bool
    {
        if (!$user) {
            return false;
        }

        // Backoffice (admin/suporte/finance/dev) vê tudo.
        if (method_exists($user, 'isBackoffice') && $user->isBackoffice()) {
            return true;
        }

        return $this->clientHas($user->client, $feature);
    }

    public function clientHas(?Client $client, string $feature): bool
    {
        if (!$client) {
            return false;
        }
        return $client->hasFeature($feature);
    }
}
