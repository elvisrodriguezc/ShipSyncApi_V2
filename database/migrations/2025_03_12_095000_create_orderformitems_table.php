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
        Schema::create('orderformitems', function (Blueprint $table) {
            $table->id();
            $table->foreignId('orderform_id')->constrained()->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('unit_id')->constrained()->onDelete('restrict')->onUpdate('cascade');
            $table->decimal('quantity', 10, 2)->default(0);
            $table->decimal('unit_price', 10, 2)->default(0);
            $table->unsignedTinyInteger('status')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orderformitems');
    }
};
