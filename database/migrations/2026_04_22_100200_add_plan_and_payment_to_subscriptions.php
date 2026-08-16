<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Associa cada assinatura ao plano e ao método de pagamento utilizado.
 */
return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('subscriptions')) {
            return;
        }

        Schema::table('subscriptions', function (Blueprint $table) {
            if (!Schema::hasColumn('subscriptions', 'plan_id')) {
                $table->foreignId('plan_id')
                    ->nullable()
                    ->after('site_id')
                    ->constrained('plans')
                    ->nullOnDelete();
            }

            if (!Schema::hasColumn('subscriptions', 'payment_method')) {
                $table->string('payment_method', 30)->nullable()->after('plan_id');
            }
        });
    }

    public function down()
    {
        if (!Schema::hasTable('subscriptions')) {
            return;
        }

        Schema::table('subscriptions', function (Blueprint $table) {
            if (Schema::hasColumn('subscriptions', 'plan_id')) {
                try {
                    $table->dropForeign(['plan_id']);
                } catch (\Throwable $e) {
                    // ignore
                }
                $table->dropColumn('plan_id');
            }
            if (Schema::hasColumn('subscriptions', 'payment_method')) {
                $table->dropColumn('payment_method');
            }
        });
    }
};
