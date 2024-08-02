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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('office_id')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('user_id')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('numerator_id')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->integer('number')->nullable();
            $table->foreignId('tariff_id')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('currency_id')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('table_id')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('entity_id')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->tinyInteger('pax')->default(1)->nullable();
            $table->decimal('discount', 11, 2)->default(0)->nullable();
            $table->decimal('total', 11, 2)->default(0);
            $table->foreignId('cashier_id')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
