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
            $table->string('name')->nullable();
            $table->float('value')->nullable();
            $table->unsignedTinyInteger('status')->default(1);
            $table->timestamps();
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
