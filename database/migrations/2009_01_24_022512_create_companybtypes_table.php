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
        Schema::create('companybtypes', function (Blueprint $table) {
            $table->id();
            $table->string('business_type'); // Type of business (e.g., Restaurant, Supermarket)
            $table->text('description');    // Description of the business type
            $table->enum('status', ['activo', 'inactivo']); // Status of the business type
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companybtypes');
    }
};
