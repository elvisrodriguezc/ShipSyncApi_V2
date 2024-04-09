<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreignId('numerator_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->unsignedInteger('number');
            $table->date('date');
            $table->foreignId('user_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreignId('entity_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->text('note')->nullable();
            $table->unsignedTinyInteger('status')->default(1);
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
