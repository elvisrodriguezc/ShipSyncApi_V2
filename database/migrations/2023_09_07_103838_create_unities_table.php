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
        Schema::create('unities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('typevalues_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->string('name', 50);
            $table->string('abbreviation', 3);
            $table->decimal('value', 8, 2);
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
            $table->unique(['typevalues_id', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unities');
    }
};
