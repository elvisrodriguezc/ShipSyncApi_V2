<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('company_id')->constrained()->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('warehouse_id')->constrained()->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('entity_id')->constrained()->onDelete('restrict')->onUpdate('cascade');
            $table->string('tipo_comprobante', 20);
            $table->string('numero_comprobante', 50);
            $table->date('fecha_emision');
            $table->date('fecha_ingreso');
            $table->decimal('peso_bruto', 10, 2)->default(0);
            $table->tinyInteger('status')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
