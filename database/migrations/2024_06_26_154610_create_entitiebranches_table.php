<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('entitiebranches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entity_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreignId('ubigeodistrito_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->string('address');
            $table->string('phone');
            $table->string('latitud');
            $table->string('longitud');
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entitiebranches');
    }
};
