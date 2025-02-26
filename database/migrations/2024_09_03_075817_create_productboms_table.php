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
        Schema::create('productboms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreignId('bom_id')->constrained('products')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreignId('unity_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->float('quantity')->default(1);
            $table->float('price')->default(0);
            $table->unsignedTinyInteger('status')->default(1);
            $table->timestamps();
            $table->unique(['product_id', 'bom_id', 'unity_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productboms');
    }
};
