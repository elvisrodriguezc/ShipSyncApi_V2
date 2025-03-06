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
        Schema::create('entities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->string('mode', 4); // C=Customer, 2=Supplier
            $table->string('ruc', 11);
            $table->string('razon_social', 150);
            $table->string('estado', 15);
            $table->string('condicion', 15);
            $table->string('ubigeo', 6);
            $table->string('tipo_via', 100);
            $table->string('nombre_via', 100);
            $table->string('codigo_zona', 30);
            $table->string('tipo_zona', 100);
            $table->string('numero', 20);
            $table->string('interior', 50);
            $table->string('lote', 50);
            $table->string('departamento', 50);
            $table->string('manzana', 50);
            $table->string('kilometro', 50);
            $table->tinyInteger('status')->default(1);
            $table->softDeletes();
            $table->timestamps();
            // indices compuestos
            $table->unique(['company_id', 'ruc']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entities');
    }
};
