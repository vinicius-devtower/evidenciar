<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Torna users.client_id NULLABLE.
     *
     * Assinantes (role=client) continuam obrigatoriamente vinculados a um Client,
     * mas usuários internos (admin/support/finance/dev) não pertencem a nenhum
     * tenant e precisam gravar client_id = NULL.
     *
     * Como o projeto não depende de doctrine/dbal, não podemos usar ->change().
     * Fazemos via SQL cru, com branch por driver.
     */
    public function up(): void
    {
        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'sqlite') {
            // SQLite não tem ALTER COLUMN. Recriamos a tabela preservando os dados.
            Schema::disableForeignKeyConstraints();

            Schema::rename('users', 'users_old_nullable_client');

            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->foreignId('client_id')->nullable()
                    ->constrained()->restrictOnDelete();
                $table->string('name');
                $table->string('email')->unique();
                $table->string('password');
                $table->string('role')->default('client');
                $table->rememberToken()->nullable();
                $table->timestamps();
                $table->softDeletes();
            });

            DB::statement('
                INSERT INTO users
                    (id, client_id, name, email, password, role,
                     remember_token, created_at, updated_at, deleted_at)
                SELECT
                    id, client_id, name, email, password, role,
                    remember_token, created_at, updated_at, deleted_at
                FROM users_old_nullable_client
            ');

            Schema::drop('users_old_nullable_client');

            Schema::enableForeignKeyConstraints();
            return;
        }

        if ($driver === 'pgsql') {
            DB::statement('ALTER TABLE users ALTER COLUMN client_id DROP NOT NULL');
            return;
        }

        // MySQL / MariaDB — mantém a FK, só afrouxa o NOT NULL.
        DB::statement('ALTER TABLE users MODIFY client_id BIGINT UNSIGNED NULL');
    }

    public function down(): void
    {
        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'sqlite') {
            Schema::disableForeignKeyConstraints();

            // Antes de voltar a NOT NULL, descarta usuários internos (client_id IS NULL)
            // para não violar a constraint recriada.
            DB::table('users')->whereNull('client_id')->delete();

            Schema::rename('users', 'users_old_not_null_client');

            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->foreignId('client_id')->constrained()->restrictOnDelete();
                $table->string('name');
                $table->string('email')->unique();
                $table->string('password');
                $table->string('role')->default('client');
                $table->rememberToken()->nullable();
                $table->timestamps();
                $table->softDeletes();
            });

            DB::statement('
                INSERT INTO users
                    (id, client_id, name, email, password, role,
                     remember_token, created_at, updated_at, deleted_at)
                SELECT
                    id, client_id, name, email, password, role,
                    remember_token, created_at, updated_at, deleted_at
                FROM users_old_not_null_client
            ');

            Schema::drop('users_old_not_null_client');

            Schema::enableForeignKeyConstraints();
            return;
        }

        if ($driver === 'pgsql') {
            DB::table('users')->whereNull('client_id')->delete();
            DB::statement('ALTER TABLE users ALTER COLUMN client_id SET NOT NULL');
            return;
        }

        // MySQL / MariaDB
        DB::table('users')->whereNull('client_id')->delete();
        DB::statement('ALTER TABLE users MODIFY client_id BIGINT UNSIGNED NOT NULL');
    }
};
