<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('sites', function (Blueprint $table) {
            $table->longText('compiled_html')->nullable()->after('content');
        });
    }

    public function down()
    {
        Schema::table('sites', function (Blueprint $table) {
            $table->dropColumn('compiled_html');
        });
    }
};
