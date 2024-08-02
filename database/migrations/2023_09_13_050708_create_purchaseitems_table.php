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
        Schema::create('purchaseitems', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreignId('product_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreignId('unity_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->decimal('price', 8, 4);
            $table->decimal('quantity', 8, 4)->default(1);
            $table->decimal('discount', 8, 4)->nullable();
            $table->integer('discount_percent')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchaseitems');
    }
};
