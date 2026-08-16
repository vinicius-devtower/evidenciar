<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('domains', function (Blueprint $table) {
            $table->foreignId('client_id')
                ->nullable()
                ->after('site_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->index('client_id');
        });

        // 🧠 Backfill
        DB::statement('
            UPDATE domains d
            JOIN sites s ON s.id = d.site_id
            SET d.client_id = s.client_id
        ');
    }

    public function down(): void
    {
        Schema::table('domains', function (Blueprint $table) {
            $table->dropForeign(['client_id']);
            $table->dropColumn('client_id');
        });
    }
};