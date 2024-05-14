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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreignId('warehouse_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->string('name', 50);
            $table->string('user', 20);
            $table->string('role', 20);
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->foreignId('typevalue_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT')->default(3);
            $table->string('documento');
            $table->string('cargo');
            $table->unsignedTinyInteger('isAF');
            $table->unsignedTinyInteger('isAFP');
            $table->foreignId('payrollafp_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT')->default(1);
            $table->float('salary');
            $table->float('additionalpay');
            $table->timestamps();
            $table->unique(['company_id', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
