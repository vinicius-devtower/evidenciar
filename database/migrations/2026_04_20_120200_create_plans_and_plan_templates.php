<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Catalogo de planos (assinaturas) e a associação de templates a planos.
     * A tabela `plans` não existia: criamos como referência leve aqui para
     * que a equipe de desenvolvimento possa informar em quais planos cada
     * template está disponível.
     */
    public function up()
    {
        if (!Schema::hasTable('plans')) {
            Schema::create('plans', function (Blueprint $table) {
                $table->id();
                $table->string('slug')->unique();
                $table->string('name');
                $table->string('description')->nullable();
                $table->unsignedInteger('price_cents')->default(0);
                $table->string('billing_cycle', 20)->default('monthly'); // monthly, yearly
                $table->boolean('is_active')->default(true);
                $table->timestamps();
                $table->softDeletes();
            });
        }

        if (!Schema::hasTable('plan_templates')) {
            Schema::create('plan_templates', function (Blueprint $table) {
                $table->id();
                $table->foreignId('plan_id')->constrained()->cascadeOnDelete();
                $table->foreignId('template_id')->constrained()->cascadeOnDelete();
                $table->timestamps();
                $table->unique(['plan_id', 'template_id']);
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('plan_templates');
        Schema::dropIfExists('plans');
    }
};
