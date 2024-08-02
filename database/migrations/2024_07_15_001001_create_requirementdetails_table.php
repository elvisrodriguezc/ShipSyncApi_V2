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
        Schema::create('requirementdetails', function (Blueprint $table) {
            $table->id();
            $table->foreignId('requirement_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreignId('product_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->boolean('nonexistent')->default(false);
            $table->string('detail')->nullable();
            $table->foreignId('unity_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->float('quantity', 11, 2, true)->default(0);
            $table->unsignedBigInteger('updatedby_id')->nullable();
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
        Schema::dropIfExists('requirementdetails');
    }
};
