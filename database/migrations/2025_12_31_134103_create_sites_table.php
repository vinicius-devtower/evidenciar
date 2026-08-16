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
        Schema::create('sites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->foreignId('template_version_id')->constrained()->restrictOnDelete();
            $table->string('name');
            $table->string('slug');
            $table->enum('status', ['draft', 'published', 'suspended'])->default('draft');
            $table->json('content')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['client_id', 'slug']);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sites');
    }
};
