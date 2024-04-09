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
            $table->foreignId('typevalue_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreignId('vehicle_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->unsignedTinyInteger('folios')->nullable();
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
