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
        Schema::create('servicedettipdets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('servicedettip_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreignId('user_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->float('amount');
            $table->unsignedTinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servicedettipdets');
    }
};
