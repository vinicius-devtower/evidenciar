<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Amplia publication_requests para suportar o workflow do suporte:
     *  - novos status (awaiting_client_info, dns_pending, ready_to_publish, cancelled)
     *  - domain_info JSON (coletado no fluxo guiado do cliente)
     *  - checklist JSON (confirmado pelo cliente antes de enviar)
     *  - assigned_to (usuário do suporte responsável)
     *  - last_status_at (para SLA/relatórios)
     *
     * SQLite/MariaDB: a coluna status é enum; como alterar enum em SQLite
     * exige workaround, convertemos para string (varchar) simples.
     */
    public function up()
    {
        // 1) Converter enum status em string para aceitar novos valores.
        //    SQLite não tem ALTER COLUMN real, então preservamos dados via coluna temporária.
        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'sqlite') {
            Schema::table('publication_requests', function (Blueprint $table) {
                $table->string('status_new', 32)->default('requested')->after('status');
            });
            DB::table('publication_requests')->update([
                'status_new' => DB::raw('status'),
            ]);
            Schema::table('publication_requests', function (Blueprint $table) {
                $table->dropColumn('status');
            });
            Schema::table('publication_requests', function (Blueprint $table) {
                $table->renameColumn('status_new', 'status');
            });
        } else {
            // MySQL/MariaDB/PgSQL
            DB::statement("ALTER TABLE publication_requests MODIFY status VARCHAR(32) NOT NULL DEFAULT 'requested'");
        }

        // 2) Colunas novas
        Schema::table('publication_requests', function (Blueprint $table) {
            if (!Schema::hasColumn('publication_requests', 'domain_info')) {
                $table->json('domain_info')->nullable()->after('notes');
            }
            if (!Schema::hasColumn('publication_requests', 'checklist')) {
                $table->json('checklist')->nullable()->after('domain_info');
            }
            if (!Schema::hasColumn('publication_requests', 'assigned_to')) {
                $table->foreignId('assigned_to')->nullable()
                    ->after('checklist')
                    ->constrained('users')
                    ->nullOnDelete();
            }
            if (!Schema::hasColumn('publication_requests', 'last_status_at')) {
                $table->timestamp('last_status_at')->nullable()->after('assigned_to');
            }
        });
    }

    public function down()
    {
        Schema::table('publication_requests', function (Blueprint $table) {
            if (Schema::hasColumn('publication_requests', 'assigned_to')) {
                $table->dropConstrainedForeignId('assigned_to');
            }
            foreach (['domain_info', 'checklist', 'last_status_at'] as $col) {
                if (Schema::hasColumn('publication_requests', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
