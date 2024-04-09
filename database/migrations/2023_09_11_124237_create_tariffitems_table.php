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
        Schema::create('tariffitems', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tariff_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->decimal('price', 8, 2);
            $table->foreignId('warehouse_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreignId('product_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreignId('currency_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tariffitems');
    }
};
