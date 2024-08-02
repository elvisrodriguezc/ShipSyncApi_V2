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
        Schema::create('orderservices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('warehouse_id')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->unsignedBigInteger('updateby_id');
            $table->timestamp('starting')->default(now());
            $table->timestamp('finishing')->nullable();
            $table->string('note')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
            $table->foreign('updateby_id')->references('id')->on('typevalues')->onUpdate('CASCADE')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orderservices');
    }
};
