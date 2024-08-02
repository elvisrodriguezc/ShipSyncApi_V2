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
        Schema::create('warehousekardexes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('warehouse_id')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('user_id')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('product_id')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('unity_id')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->decimal('in', 8, 2)->comment("quantity");
            $table->decimal('out', 8, 2)->comment("quantity");
            $table->decimal('price', 8, 2);
            $table->decimal('prevstock', 8, 2);
            $table->decimal('stock', 8, 2);
            $table->bigInteger('purchaseitem_id')->nullable()->comment("Just in case its the origen");
            $table->bigInteger('orderitem_id')->nullable()->comment("Just in case its the origen");
            $table->bigInteger('transferitem_id')->nullable()->comment("Just in case its the origen");
            $table->bigInteger('inventoryitem_id')->nullable()->comment("Just in case its the origen");
            $table->string('detail')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warehousekardexes');
    }
};
