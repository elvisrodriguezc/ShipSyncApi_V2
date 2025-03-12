<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreignId('headquarter_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreignId('warehouse_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('username', 50)->unique();
            $table->foreignId('role_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreignId('document_id')->constrained('typevalues')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->string('document_number', 10)->unique();
            $table->string('phone', 15)->nullable();
            $table->string('address', 100)->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->string('license', 10)->nullable();
            $table->string('licencecategory', 10)->nullable();
            $table->unsignedTinyInteger('isAF')->nullable();
            $table->unsignedTinyInteger('isAFP')->nullable();
            $table->foreignId('payrollafp_id')->nullable()->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT')->default(1);
            $table->float('salary')->nullable();
            $table->float('additionalpay')->nullable();
            $table->boolean('status')->default(1);
            $table->softDeletes();
            $table->unique(['company_id', 'document_id', 'document_number']);
            $table->unique(['company_id', 'username']);
            $table->unique(['company_id', 'email']);
            $table->timestamps();
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
