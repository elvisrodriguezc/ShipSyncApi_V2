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
        Schema::create('guidecarrierdocs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guidecarrier_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->string("ruc", 11);
            $table->string("serie", 5);
            $table->unsignedInteger("number");
            $table->unsignedBigInteger("tipocepe_id");
            $table->unsignedTinyInteger("status")->default(1);
            $table->foreign('tipocpe_id')->references('id')->on('typevalues')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guidecarrierdocs');
    }
};
