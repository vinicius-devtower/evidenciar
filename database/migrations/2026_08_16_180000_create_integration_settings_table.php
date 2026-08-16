<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Configurações de integrações externas, editáveis via
 * /dev/integracoes/{provider} pelo painel do SuperAdmin.
 *
 * Uma linha por provider (hoje só "mercadopago"). Campos sensíveis
 * (access_token, client_secret, webhook_secret) são criptografados em
 * repouso via cast `encrypted` no model.
 *
 * Se uma coluna vier vazia, o app cai pra trás no valor do .env
 * (ver App\Services\MercadoPagoSettings) — isso existe pra não quebrar
 * nenhum ambiente que ainda não passou pela tela.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('integration_settings', function (Blueprint $table) {
            $table->id();
            $table->string('provider')->unique(); // 'mercadopago'
            $table->text('public_key')->nullable();
            $table->text('access_token')->nullable();
            $table->text('client_id')->nullable();
            $table->text('client_secret')->nullable();
            $table->text('webhook_secret')->nullable();
            $table->string('notification_url')->nullable();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('integration_settings');
    }
};
