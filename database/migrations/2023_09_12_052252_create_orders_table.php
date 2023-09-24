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
            $table->integer('number')->nullable();
            $table->tinyInteger('pax')->default(1)->nullable();
            $table->decimal('discount', 11, 2)->default(0)->nullable();
            $table->decimal('total', 11, 2)->default(0);
            $table->tinyInteger('status')->default(1);
            $table->foreignId('company_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('entity_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('cashier_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('table_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('tariff_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('currency_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
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
