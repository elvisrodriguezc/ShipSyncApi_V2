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
        Schema::create('typevalues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('type_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->string('name', 50);
            $table->string('description', 100)->nullable();
            $table->string('abbreviation', 10)->nullable();
            $table->unsignedTinyInteger('status')->default(1);
            $table->softDeletes();
            $table->timestamps();
            //Indice compuesto
            $table->unique(['type_id', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('typevalues');
    }
};
