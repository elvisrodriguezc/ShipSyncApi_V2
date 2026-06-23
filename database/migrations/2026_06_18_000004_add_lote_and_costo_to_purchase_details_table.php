<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('purchase_details', function (Blueprint $table) {
            $table->foreignId('id_lote')->nullable()->constrained('batches', 'id_lote')->nullOnDelete()->cascadeOnUpdate();
            $table->decimal('costo_unitario', 12, 4)->nullable()->after('cantidad');
        });
    }

    public function down(): void
    {
        Schema::table('purchase_details', function (Blueprint $table) {
            $table->dropForeign(['id_lote']);
            $table->dropColumn(['id_lote', 'costo_unitario']);
        });
    }
};
