<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Thread de mensagens entre assinante e suporte para cada publicação.
     */
    public function up()
    {
        Schema::create('publication_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('publication_request_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            // Cacheado para filtrar rápido por lado (client/support/admin/etc.)
            $table->string('author_role', 20)->default('client');
            $table->text('body');
            $table->json('attachments')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['publication_request_id', 'created_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('publication_messages');
    }
};
