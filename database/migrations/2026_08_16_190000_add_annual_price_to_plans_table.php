<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Preço anual "à vista" (PIX/cartão 1x, sem assinatura recorrente anual).
 *
 * Nullable de propósito: se ficar vazio, App\Models\Plan calcula um
 * fallback de 20% OFF sobre o preço mensal (mesma lógica de fallback já
 * usada em App\Services\MercadoPagoSettings) — assim nenhum plano fica sem
 * preço anual só porque ninguém preencheu ainda.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->unsignedInteger('annual_price_cents')->nullable()->after('price_cents');
        });
    }

    public function down(): void
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->dropColumn('annual_price_cents');
        });
    }
};
