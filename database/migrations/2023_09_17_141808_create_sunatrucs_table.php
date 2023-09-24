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
        Schema::create('sunatrucs', function (Blueprint $table) {
            $table->id();
            $table->string('ruc', 11)->unique();
            $table->string('razon_social', 150);
            $table->string('estado', 15);
            $table->string('ubigeo', 6);
            $table->string('tipo_via', 100);
            $table->string('nombre_via', 100);
            $table->string('codigo_zona', 30);
            $table->string('numero', 20);
            $table->string('interior', 50);
            $table->string('lote', 50);
            $table->string('departamento', 50);
            $table->string('manzana', 50);
            $table->string('kilometro', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sunatrucs');
    }
};
