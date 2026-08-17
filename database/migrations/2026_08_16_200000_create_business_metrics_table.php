<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Indicadores mensais preenchidos manualmente pelos sócios (Vinicius/João)
 * em /dev/plano-negocio/indicadores — coisas que não têm como computar do
 * banco (custo de marketing, leads abordados, reuniões feitas) ficam aqui
 * ao lado de uma cópia dos números que JÁ são reais na hora do registro
 * (novos clientes, ativos, MRR) — assim a comparação com a projeção do
 * plano de negócios fica histórica, não recalculada toda vez que alguém
 * cancela.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('business_metrics', function (Blueprint $table) {
            $table->id();
            $table->date('month')->unique(); // sempre dia 1 do mês de referência

            // Preenchidos automaticamente (snapshot no momento do registro,
            // editável se o admin quiser corrigir manualmente).
            $table->unsignedInteger('new_clients')->nullable();
            $table->unsignedInteger('active_clients')->nullable();
            $table->unsignedInteger('mrr_cents')->nullable();

            // Só existem se alguém preencher — não tem como computar do banco.
            $table->unsignedInteger('marketing_spend_cents')->nullable();
            $table->unsignedInteger('leads_contacted')->nullable();
            $table->unsignedInteger('meetings_held')->nullable();
            $table->text('notes')->nullable();

            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('business_metrics');
    }
};
