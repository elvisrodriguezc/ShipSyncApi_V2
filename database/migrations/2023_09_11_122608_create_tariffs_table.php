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
        Schema::create('tariffs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('office_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->string('name');
            $table->integer('rate')->default(10);
            $table->foreignId('currency_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->unique(['office_id', 'name']);
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tariffs');
    }
};
