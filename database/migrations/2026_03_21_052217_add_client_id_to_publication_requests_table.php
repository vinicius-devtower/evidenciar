<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('publication_requests', function (Blueprint $table) {
            $table->foreignId('client_id')
                ->nullable()
                ->after('site_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->index('client_id');
        });

        // 🧠 Backfill (importantíssimo)
        DB::statement('
            UPDATE publication_requests pr
            JOIN sites s ON s.id = pr.site_id
            SET pr.client_id = s.client_id
        ');
    }

    public function down(): void
    {
        Schema::table('publication_requests', function (Blueprint $table) {
            $table->dropForeign(['client_id']);
            $table->dropColumn('client_id');
        });
    }
};