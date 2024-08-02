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
        Schema::create('transferdetails', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transfer_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreignId('product_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreignId('unity_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->decimal('quantity');
            $table->string('comments')->nullable();
            $table->unsignedBigInteger('receivinguser_id')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
            $table->foreign('receivinguser_id')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transferdetails');
    }
};
