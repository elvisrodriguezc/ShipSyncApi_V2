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
        Schema::create('servicedetspents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('servicedetail_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->string('ruc', 11);
            $table->string('serie', 5);
            $table->string('number', 15);
            $table->float('amount');
            $table->string('detail');
            $table->unsignedBigInteger('typecpe_id');
            $table->unsignedTinyInteger('status')->default(1);
            $table->timestamps();
            $table->foreign('typecpe_id')->references('id')->on('typevalues')->onUpdate('CASCADE')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servicedetspents');
    }
};
