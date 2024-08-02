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
        Schema::create('numerators', function (Blueprint $table) {
            $table->id();
            $table->foreignId('office_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->unsignedBigInteger('documenttype_id');
            $table->string('serie', 4);
            $table->unsignedInteger('number')->default(1);
            $table->string('description')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
            $table->foreign('documenttype_id')->references('id')->on('typevalues')->onUpdate('CASCADE')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('numerators');
    }
};
