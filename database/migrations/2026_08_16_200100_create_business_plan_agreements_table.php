<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Registro de "de acordo" dos sócios com a minuta de contrato do plano de
 * negócios (não é o aceite do cliente final no checkout — é uso interno,
 * pros sócios formalizarem que revisaram e concordam com a versão atual
 * da minuta antes dela virar o contrato real usado no checkout).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('business_plan_agreements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('version', 20)->default('1.0');
            $table->timestamp('agreed_at');
            $table->timestamps();

            $table->unique(['user_id', 'version']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('business_plan_agreements');
    }
};
