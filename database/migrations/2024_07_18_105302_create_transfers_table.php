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
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreignId('user_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreignId('numerator_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->unsignedInteger('number');
            $table->unsignedBigInteger('originwarehouse_id');
            $table->unsignedBigInteger('destinationwarehouse_id');
            $table->unsignedBigInteger('receivinguser_id')->nullable();
            $table->string('detail')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
            $table->foreign('originwarehouse_id')->references('id')->on('warehouses')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('destinationwarehouse_id')->references('id')->on('warehouses')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('receivinguser_id')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfers');
    }
};
