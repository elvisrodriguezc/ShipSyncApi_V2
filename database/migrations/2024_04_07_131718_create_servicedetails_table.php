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
        Schema::create('servicedetails', function (Blueprint $table) {
            $table->id();
            $table->foreignId('services_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreignId('numerator_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->unsignedInteger('number');
            $table->foreignId('typevalue_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreignId('vehicle_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->unsignedDecimal('initkm')->nullable();
            $table->unsignedDecimal('finalkm')->nullable();
            $table->unsignedDecimal('initkmGPS')->nullable();
            $table->unsignedDecimal('finalkmGPS')->nullable();
            $table->unsignedDecimal('tripLength')->nullable();
            $table->unsignedTinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servicedetails');
    }
};
