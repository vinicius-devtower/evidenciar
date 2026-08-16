<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * CheckoutIntent passa a carregar:
 * - o plano escolhido na LP (plan_id)
 * - o método de pagamento (pix | boleto | credit_card)
 * - campos auxiliares de boleto e cartão que dependem do método
 */
return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('checkout_intents')) {
            return;
        }

        Schema::table('checkout_intents', function (Blueprint $table) {
            if (!Schema::hasColumn('checkout_intents', 'plan_id')) {
                $table->foreignId('plan_id')
                    ->nullable()
                    ->after('template_id')
                    ->constrained('plans')
                    ->nullOnDelete();
            }

            if (!Schema::hasColumn('checkout_intents', 'payment_method')) {
                $table->string('payment_method', 30)
                    ->default('pix')
                    ->after('amount');
            }

            // Campos específicos de boleto
            if (!Schema::hasColumn('checkout_intents', 'boleto_url')) {
                $table->string('boleto_url', 500)->nullable()->after('qr_code_base64');
            }
            if (!Schema::hasColumn('checkout_intents', 'boleto_line')) {
                $table->string('boleto_line', 80)->nullable()->after('boleto_url');
            }

            // Campos específicos de cartão de crédito
            if (!Schema::hasColumn('checkout_intents', 'card_last4')) {
                $table->string('card_last4', 4)->nullable()->after('boleto_line');
            }
            if (!Schema::hasColumn('checkout_intents', 'card_brand')) {
                $table->string('card_brand', 30)->nullable()->after('card_last4');
            }
            if (!Schema::hasColumn('checkout_intents', 'installments')) {
                $table->unsignedTinyInteger('installments')->nullable()->after('card_brand');
            }
        });
    }

    public function down()
    {
        if (!Schema::hasTable('checkout_intents')) {
            return;
        }

        Schema::table('checkout_intents', function (Blueprint $table) {
            if (Schema::hasColumn('checkout_intents', 'plan_id')) {
                // Drop FK primeiro; em SQLite o dropForeign é silenciosamente ignorado.
                try {
                    $table->dropForeign(['plan_id']);
                } catch (\Throwable $e) {
                    // ignore
                }
                $table->dropColumn('plan_id');
            }
            foreach ([
                'payment_method',
                'boleto_url',
                'boleto_line',
                'card_last4',
                'card_brand',
                'installments',
            ] as $col) {
                if (Schema::hasColumn('checkout_intents', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
