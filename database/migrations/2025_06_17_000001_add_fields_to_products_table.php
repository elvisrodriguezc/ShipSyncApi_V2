<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('codigo', 15)->nullable()->after('name');
            $table->tinyInteger('peso')->nullable()->after('description');
            $table->tinyInteger('vida_util')->nullable()->after('peso');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['codigo', 'peso', 'vida_util']);
        });
    }
};
