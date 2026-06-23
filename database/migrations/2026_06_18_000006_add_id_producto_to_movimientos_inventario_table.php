<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('movimientos_inventario', function (Blueprint $table) {
            $table->foreignId('id_lote')->nullable()->change();
            $table->foreignId('id_producto')->nullable()->after('id_lote')->constrained('products')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('movimientos_inventario', function (Blueprint $table) {
            $table->dropForeign(['id_producto']);
            $table->dropColumn('id_producto');
            $table->foreignId('id_lote')->change();
        });
    }
};
