<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plan extends Model
{
    use HasFactory, SoftDeletes;

    /** Slugs canônicos — espelham a Landing Page. */
    public const SLUG_START        = 'start';
    public const SLUG_PROFISSIONAL = 'profissional';
    public const SLUG_GESTAO_VIP   = 'gestao_vip';

    public const ALL_SLUGS = [
        self::SLUG_START,
        self::SLUG_PROFISSIONAL,
        self::SLUG_GESTAO_VIP,
    ];

    /**
     * Matriz de funcionalidades habilitadas por plano.
     *
     * Chaves usadas pelo sistema:
     * - eva              : assistente EVA no editor
     * - multipage        : mais de uma página/seção no site
     * - priority_support : suporte prioritário
     * - vip_support      : suporte VIP (gerente dedicado)
     * - blog             : módulo de blog
     * - pro_email        : e-mail profissional no domínio
     */
    public const FEATURES_BY_SLUG = [
        self::SLUG_START => [],
        self::SLUG_PROFISSIONAL => [
            'eva',
            'multipage',
            'priority_support',
        ],
        self::SLUG_GESTAO_VIP => [
            'eva',
            'multipage',
            'blog',
            'pro_email',
            'vip_support',
        ],
    ];

    protected $fillable = [
        'slug', 'name', 'description', 'price_cents', 'billing_cycle', 'is_active', 'features',
    ];

    protected $casts = [
        'is_active'   => 'boolean',
        'price_cents' => 'integer',
        'features'    => 'array',
    ];

    public function templates()
    {
        return $this->belongsToMany(Template::class, 'plan_templates')
            ->withTimestamps();
    }

    public function priceFormatted(): string
    {
        return 'R$ ' . number_format($this->price_cents / 100, 2, ',', '.');
    }

    /**
     * Retorna a lista de features habilitadas para o plano.
     * Se existir override na coluna `features`, ela tem precedência.
     */
    public function featureList(): array
    {
        if (is_array($this->features) && !empty($this->features)) {
            return array_values($this->features);
        }
        return self::FEATURES_BY_SLUG[$this->slug] ?? [];
    }

    /** Verifica se este plano tem direito a uma feature. */
    public function hasFeature(string $key): bool
    {
        return in_array($key, $this->featureList(), true);
    }
}
