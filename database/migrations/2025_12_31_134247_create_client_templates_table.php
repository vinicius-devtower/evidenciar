<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->foreignId('template_id')->constrained()->restrictOnDelete();
            $table->enum('status', ['active', 'revoked'])->default('active');
            $table->timestamp('acquired_at')->useCurrent();
            $table->softDeletes();
            $table->unique(['client_id', 'template_id']);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client_templates');
    }
};
