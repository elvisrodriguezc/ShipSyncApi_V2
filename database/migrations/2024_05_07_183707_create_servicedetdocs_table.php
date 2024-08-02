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
        Schema::create('servicedetdocs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('servicedetail_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreignId('typevalue_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->string('serie', 5);
            $table->string('number', 20);
            $table->foreignId('ubigeodistrito_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->string('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servicedetdocs');
    }
};
