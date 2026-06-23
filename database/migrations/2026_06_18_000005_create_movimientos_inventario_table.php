<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('movimientos_inventario', function (Blueprint $table) {
            $table->id('id_movimiento');
            $table->foreignId('company_id')->constrained()->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('id_lote')->constrained('batches', 'id_lote')->onDelete('restrict')->onUpdate('cascade');
            $table->tinyInteger('tipo_movimiento')->comment('1:Ingreso_Compra, 2:Egreso_Venta, 3:Merma, 4:Ajuste_Inventario, 5:Vencimiento');
            $table->decimal('cantidad', 12, 4);
            $table->decimal('saldo', 12, 4);
            $table->dateTime('fecha_movimiento')->useCurrent();
            $table->string('documento_referencia', 100)->nullable();
            $table->foreignId('usuario_id')->constrained('users')->onDelete('restrict')->onUpdate('cascade');
            $table->timestamp('created_at')->useCurrent();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movimientos_inventario');
    }
};
