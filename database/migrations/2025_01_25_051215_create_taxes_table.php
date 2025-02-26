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
        Schema::create('taxes', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('percentage_based');
            $table->string('sunat_code', 4);
            $table->string('sunat_namecode', 4);
            $table->string('sunat_operationcode', 4);
            $table->string('name', 50);
            $table->decimal('rate', 5, 2);
            $table->decimal('value', 5, 2);
            $table->text('description');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->enum('status', ['Activo', 'Inactivo', 'Unico', 'Predeterminado'])->default('Activo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taxes');
    }
};
