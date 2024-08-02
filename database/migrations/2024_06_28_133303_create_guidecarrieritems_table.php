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
        Schema::create('guidecarrieritems', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guidecarrier_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreignId('product_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->float('quantity');
            $table->foreignId('unity_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->float('unitvalue')->nullable();
            $table->float('discount')->nullable();
            $table->float('mto_baseigv')->nullable();
            $table->float('porcentaje_igv')->nullable();
            $table->float('total_impuestos')->nullable();
            $table->float('monto_preciounitario')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guidecarrieritems');
    }
};
