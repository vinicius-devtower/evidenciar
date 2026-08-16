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
        Schema::create('template_versions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('template_id')->constrained()->restrictOnDelete();
            $table->string('version');
            $table->string('path');
            $table->boolean('is_active')->default(true);
            $table->timestamp('created_at')->useCurrent();
            $table->unique(['template_id', 'version']);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('template_versions');
    }
};
