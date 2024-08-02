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
        Schema::create('requirements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreignId('warehouse_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreignId('user_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreignId('numerator_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->unsignedInteger('number')->default(0);
            $table->foreignId('currency_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->tinyInteger('relevance')->default(1);
            $table->unsignedBigInteger('updatedby_id')->nullable();
            $table->date('deadline')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
            $table->foreign('updatedby_id')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requirements');
    }
};
