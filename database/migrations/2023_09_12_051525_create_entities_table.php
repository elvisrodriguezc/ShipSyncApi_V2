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
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('company_name');
            $table->unsignedBigInteger('idform_id');
            $table->string('idform_number', 15);
            $table->string('phone', 50)->nullable();
            $table->string('email', 50)->nullable();
            $table->foreignId('ubigeodistrito_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT')->nullable();
            $table->string('address', 100)->nullable();
            $table->string('remark', 200)->nullable();
            $table->unsignedTinyInteger('status')->default(1);
            $table->foreign('idform_id')->references('id')->on('typevalues')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->timestamps();
            $table->unique(['company_id', 'idform_number']); // adds unicity restricxtion to the fields company_id and name
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
