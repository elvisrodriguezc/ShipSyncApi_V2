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
        Schema::create('warehousestocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('warehouse_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreignId('product_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->decimal('stock', 8, 2);
            $table->decimal('reserved', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warehousestocks');
    }
};
