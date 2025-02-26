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
        Schema::create('vcandidates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')
                ->constrained()
                ->onUpdate('CASCADE')
                ->onDelete('RESTRICT');
            $table->foreignId('user_id')
                ->constrained()
                ->onUpdate('CASCADE')
                ->onDelete('RESTRICT');
            $table->string('dni');
            $table->string('name');
            $table->string('detail');
            $table->string('image');
            $table->unsignedTinyInteger('position');
            $table->unsignedtinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vcandidates');
    }
};
