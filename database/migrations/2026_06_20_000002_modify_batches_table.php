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
        Schema::table('batches', function (Blueprint $table) {
            // Drop columns if they exist
            if (Schema::hasColumn('batches', 'numero_lote_proveedor')) {
                $table->dropColumn('numero_lote_proveedor');
            }
            if (Schema::hasColumn('batches', 'fecha_fabricacion')) {
                $table->dropColumn('fecha_fabricacion');
            }

            // Add columns if they do not exist
            if (!Schema::hasColumn('batches', 'id_producto')) {
                $table->foreignId('id_producto')->after('company_id')->constrained('products')->onDelete('restrict')->onUpdate('cascade');
            } else {
                try {
                    $table->foreign('id_producto')->references('id')->on('products')->onDelete('restrict')->onUpdate('cascade');
                } catch (\Exception $e) {
                    // Ignore if already exists
                }
            }
            if (!Schema::hasColumn('batches', 'stock_actual')) {
                $table->decimal('stock_actual', 12, 4)->default(0)->after('fecha_vencimiento');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('batches', function (Blueprint $table) {
            if (Schema::hasColumn('batches', 'id_producto')) {
                try {
                    $table->dropForeign(['id_producto']);
                } catch (\Exception $e) {}
                $table->dropColumn('id_producto');
            }
            if (Schema::hasColumn('batches', 'stock_actual')) {
                $table->dropColumn('stock_actual');
            }
            if (!Schema::hasColumn('batches', 'numero_lote_proveedor')) {
                $table->string('numero_lote_proveedor', 30)->nullable();
            }
            if (!Schema::hasColumn('batches', 'fecha_fabricacion')) {
                $table->date('fecha_fabricacion')->nullable();
            }
        });
    }
};
