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
        Schema::create('entities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('company_name')->nullable();
            $table->foreignId('idform_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->string('idform_number', 15);
            $table->string('phone', 50)->nullable();
            $table->string('email', 50);
            $table->foreignId('ubigeodistrito_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->string('address', 100)->nullable();
            $table->string('remark', 200)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entities');
    }
};
