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
        Schema::create('guidecarriers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreignId('user_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreignId('numerator_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->unsignedInteger('number')->default(0);
            $table->timestamp('release_date')->default(now());
            $table->timestamp('transfer_date')->nullable();
            $table->unsignedBigInteger('sender_id');
            $table->unsignedBigInteger('senderbranch_id');
            $table->unsignedBigInteger('destination_id');
            $table->unsignedBigInteger('destinationbranch_id');
            $table->unsignedBigInteger('driver_id')->nullable();
            $table->foreignId('vehicle_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->unsignedBigInteger('tercero_id')->nullable();
            $table->unsignedBigInteger('subcontratado_id')->nullable();
            $table->unsignedBigInteger('tipoindicador_id')->nullable();
            $table->string('pesobruto')->nullable();
            $table->string('nota')->nullable();
            $table->string('numTicket')->nullable();
            $table->timestamp('fecRecepcion')->nullable();
            $table->string('codRespuesta')->nullable();
            $table->string('indCdrGenerado')->nullable();
            $table->string('numError')->nullable();
            $table->string('desError')->nullable();
            $table->string('arcCdr')->nullable();
            $table->string('hash')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->foreign('driver_id')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('sender_id')->references('id')->on('entities')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('senderbranch_id')->references('id')->on('entitiebranches')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('destination_id')->references('id')->on('entities')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('destinationbranch_id')->references('id')->on('entitiebranches')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('tercero_id')->references('id')->on('entities')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('subcontratado_id')->references('id')->on('entities')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('tipoindicador_id')->references('id')->on('typevalues')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guidecarriers');
    }
};
