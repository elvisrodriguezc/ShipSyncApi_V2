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
        Schema::create('payroll_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payroll_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreignId('user_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->float('base');
            $table->float('aditional');
            $table->float('services');
            $table->unsignedTinyInteger('isAF');
            $table->unsignedTinyInteger('isAFP');
            $table->foreignId('payrollafp_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT')->default(1);
            $table->float('totalremuneracion');
            $table->float('totalaporteempleador');
            $table->unsignedTinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payroll_users');
    }
};
