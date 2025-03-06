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
        Schema::create('entityhqrs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entity_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreignId('ubigeodistrito_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->string('address', 150);
            $table->string('reference', 150)->nullable();
            $table->string('phone', 15)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('contact', 100)->nullable();
            $table->string('contact_phone', 15)->nullable();
            $table->string('contact_email', 100)->nullable();
            $table->string('latitude', 50)->nullable();
            $table->string('longitude', 50)->nullable();
            $table->unsignedTinyInteger('status')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entityhqrs');
    }
};
