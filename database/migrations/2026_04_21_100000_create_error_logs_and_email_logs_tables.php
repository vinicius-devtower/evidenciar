<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabelas estruturadas para a tela "Logs" do Suporte.
     *
     * error_logs: cada exceção/erro que o ExceptionHandler reportar.
     *   - code: derivado de hash(exception_class|file|line). Mesma origem → mesmo código.
     *   - severity: debug|info|notice|warning|error|critical|alert|emergency
     *   - context: qualquer contexto adicional (chaves do Monolog, IDs relacionados)
     *   - request_payload: input sanitizado (sem passwords)
     *
     * email_logs: cada e-mail que saiu do Mail::send / Notification::send.
     *   - status: sending|sent|failed
     *   - meta: array com variáveis usadas no template (se o mailable expuser)
     */
    public function up(): void
    {
        Schema::create('error_logs', function (Blueprint $table) {
            $table->id();
            $table->string('code', 32)->index();            // EVD-XXXXXX
            $table->string('severity', 16)->default('error')->index();
            $table->string('exception_class')->nullable();
            $table->text('message');
            $table->string('file')->nullable();
            $table->unsignedInteger('line')->nullable();
            $table->longText('trace')->nullable();

            $table->string('url', 2048)->nullable();
            $table->string('method', 16)->nullable();
            $table->json('request_payload')->nullable();
            $table->json('context')->nullable();

            $table->foreignId('user_id')->nullable()
                ->constrained('users')->nullOnDelete();

            $table->timestamp('occurred_at')->useCurrent()->index();
            $table->timestamps();

            $table->index(['code', 'occurred_at']);
        });

        Schema::create('email_logs', function (Blueprint $table) {
            $table->id();
            $table->string('to');
            $table->string('subject');
            $table->string('mailable_class')->nullable();
            $table->string('status', 16)->default('sending')->index();
            $table->text('error')->nullable();
            $table->json('meta')->nullable();

            $table->foreignId('user_id')->nullable()
                ->constrained('users')->nullOnDelete();

            $table->timestamp('sent_at')->nullable();
            $table->timestamps();

            $table->index(['to', 'status']);
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('email_logs');
        Schema::dropIfExists('error_logs');
    }
};
