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
        Schema::create('advancements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreignId('user_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreignId('typevalue_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->unsignedBigInteger('servicedetail_id')->nullable(); //only if is a  discount by work reazon
            $table->string('detail');
            $table->string('document')->nullable();
            $table->float('amount');
            $table->tinyInteger('installments');
            $table->unsignedBigInteger('manager_id'); //updatedBy
            $table->foreign('manager_id')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->unsignedTinyInteger('status')->default(1);
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advancements');
    }
};
