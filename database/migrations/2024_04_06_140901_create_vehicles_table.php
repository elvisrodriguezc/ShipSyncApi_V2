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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreignId('entity_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->string('ruc', 11);
            $table->string('name', 20);
            $table->string('matricula', 7);
            $table->string('marca', 30);
            $table->string('modelo', 30);
            $table->string('color', 100);
            $table->string('aniofabricacion', 4);
            $table->string('tuc', 50);
            $table->text('observaciones', 100)->nullable();
            $table->string('image', 100);
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
