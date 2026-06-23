<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('batches', function (Blueprint $table) {
            $table->id('id_lote');
            $table->foreignId('company_id')->constrained()->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('id_producto')->constrained('products')->onDelete('restrict')->onUpdate('cascade');
            $table->string('numero_lote_proveedor', 30);
            $table->date('in_date')->default(DB::raw('CURRENT_DATE'));
            $table->date('fecha_fabricacion')->nullable();
            $table->date('fecha_vencimiento');
            $table->tinyInteger('estado')->default(1)->comment('1: Activo, 2: Vencido, 3: Retirado, 4: Cuarentena');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('batches');
    }
};
