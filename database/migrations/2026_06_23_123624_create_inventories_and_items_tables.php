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
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreignId('headquarter_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreignId('warehouse_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreignId('user_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreignId('numerator_id')->nullable()->constrained()->onUpdate('CASCADE')->onDelete('SET NULL');
            $table->string('number');
            $table->dateTime('date');
            $table->text('notes')->nullable();
            $table->tinyInteger('status')->default(1)->comment('1: Draft, 2: Completed');
            $table->timestamps();
        });

        Schema::create('inventory_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventory_id')->constrained()->onUpdate('CASCADE')->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->decimal('system_stock', 12, 3)->default(0);
            $table->decimal('physical_stock', 12, 3)->default(0);
            $table->decimal('difference', 12, 3)->default(0);
            $table->text('observation')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_items');
        Schema::dropIfExists('inventories');
    }
};
