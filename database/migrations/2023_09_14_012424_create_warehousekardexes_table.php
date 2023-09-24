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
            $table->foreignId('warehouse_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->decimal('prevstock', 8, 2);
            $table->decimal('in', 8, 2);
            $table->decimal('out', 8, 2);
            $table->decimal('stock', 8, 2);
            $table->bigInteger('purchaseitem_id');
            $table->bigInteger('orderitem_id');
            $table->bigInteger('transfer_id');
            $table->bigInteger('inventory_id');
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
