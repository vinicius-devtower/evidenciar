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

    /**
     * Quantos meses o cliente paga de fato no ciclo anual (fallback quando
     * o plano não tem annual_price_cents definido) — "pague 10, leve 12",
     * o mesmo enquadramento usado no plano de negócios ("2 meses grátis").
     */
    public const ANNUAL_MONTHS_CHARGED = 10;

    protected $fillable = [
        'slug', 'name', 'description', 'price_cents', 'annual_price_cents', 'billing_cycle', 'is_active', 'features',
    ];

    protected $casts = [
        'is_active'          => 'boolean',
        'price_cents'        => 'integer',
        'annual_price_cents' => 'integer',
        'features'           => 'array',
    ];

    public function templates()
    {
        return $this->belongsToMany(Template::class, 'plan_templates')
            ->withTimestamps();
    }

    public function priceFormatted(): string
    {
        return $this->formatCents($this->price_cents);
    }

    /**
     * Preço anual "à vista" em centavos. Usa annual_price_cents se
     * preenchido (editável em /dev/planos); senão calcula
     * ANNUAL_MONTHS_CHARGED meses ("pague 10, leve 12").
     */
    public function annualPriceCents(): int
    {
        if (!empty($this->annual_price_cents)) {
            return $this->annual_price_cents;
        }
        return $this->price_cents * self::ANNUAL_MONTHS_CHARGED;
    }

    public function annualPriceFormatted(): string
    {
        return $this->formatCents($this->annualPriceCents());
    }

    /** Preço anual dividido por 12 — pra mostrar como "R$X/mês" no plano anual. */
    public function annualMonthlyEquivalentFormatted(): string
    {
        return $this->formatCents((int) round($this->annualPriceCents() / 12));
    }

    /** Quanto se economiza por ano em relação a pagar 12x o valor mensal. */
    public function annualSavingsCents(): int
    {
        return max(0, ($this->price_cents * 12) - $this->annualPriceCents());
    }

    public function annualSavingsFormatted(): string
    {
        return $this->formatCents($this->annualSavingsCents());
    }

    /** % de desconto real do anual em relação a 12x o mensal (arredondado). */
    public function annualDiscountPercent(): int
    {
        $fullYear = $this->price_cents * 12;
        if ($fullYear <= 0) {
            return 0;
        }
        return (int) round(($this->annualSavingsCents() / $fullYear) * 100);
    }

    /** Preço em centavos pro ciclo informado ('monthly' ou 'annual'). */
    public function priceCentsForCycle(string $cycle): int
    {
        return $cycle === 'annual' ? $this->annualPriceCents() : $this->price_cents;
    }

    public function priceFormattedForCycle(string $cycle): string
    {
        return $this->formatCents($this->priceCentsForCycle($cycle));
    }

    protected function formatCents(int $cents): string
    {
        return 'R$ ' . number_format($cents / 100, 2, ',', '.');
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
