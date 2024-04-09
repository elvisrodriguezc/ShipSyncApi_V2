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
            $table->foreignId('company_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreignId('document_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->string('serie', 4);
            $table->unsignedInteger('number')->default(1);
            $table->string('description')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
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
