<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * CheckoutIntent representa uma tentativa de checkout iniciada pelo cliente
 * ANTES do pagamento ser confirmado. Armazena o QR Code PIX, os dados
 * coletados na jornada e o external_id retornado pelo Mercado Pago.
 *
 * Quando o webhook confirma o pagamento, o CheckoutIntent é casado por
 * external_id e os registros finais (Client, User, Site, Subscription,
 * Payment) são criados.
 */
return new class extends Migration {
    public function up(): void
    {
        Schema::create('checkout_intents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('template_id')->nullable();
            $table->string('external_id')->unique();      // payment.id do MP
            $table->string('name');
            $table->string('email');
            $table->string('whatsapp')->nullable();
            $table->string('documento')->nullable();
            $table->decimal('amount', 10, 2);
            $table->text('qr_code')->nullable();           // copia-e-cola
            $table->longText('qr_code_base64')->nullable(); // imagem PNG base64
            $table->json('journey_data')->nullable();       // tudo que o cliente preencheu na jornada
            $table->timestamp('expires_at')->nullable();
            $table->enum('status', ['pending', 'approved', 'expired', 'failed'])->default('pending');
            $table->timestamps();

            $table->index('email');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('checkout_intents');
    }
};
