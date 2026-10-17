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
        Schema::create('orderform_deliveries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreignId('orderform_id')->constrained('orderforms')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreignId('car_id')->nullable()->constrained('cars')->onUpdate('CASCADE')->onDelete('SET NULL');
            $table->foreignId('person_id')->nullable()->constrained('persons')->onUpdate('CASCADE')->onDelete('SET NULL');
            $table->integer('trayquantity')->default(0);
            $table->integer('tray_returned_quantity')->default(0);
            $table->dateTime('returned')->nullable();
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
        Schema::dropIfExists('orderform_deliveries');
    }
};
