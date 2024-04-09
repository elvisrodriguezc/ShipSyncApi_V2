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
        Schema::create('offices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->string('name', 100);
            $table->string('address', 100);
            $table->string('phone', 20)->nullable();
            $table->string('email', 60)->nullable();
            $table->tinyInteger('status')->default(1);
            $table->foreignId('ubigeodistrito_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offices');
    }
};
