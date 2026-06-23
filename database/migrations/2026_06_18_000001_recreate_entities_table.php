<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('entities');

        Schema::create('entities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->string('mode', 4);
            $table->string('ruc', 11);
            $table->string('razon_social', 150);
            $table->string('ubigeo', 6)->nullable();
            $table->string('address', 255)->nullable();
            $table->tinyInteger('status')->default(1);
            $table->softDeletes();
            $table->timestamps();
            $table->unique(['company_id', 'ruc']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('entities');

        Schema::create('entities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->string('mode', 4);
            $table->string('ruc', 11);
            $table->string('razon_social', 150);
            $table->string('estado', 15)->nullable();
            $table->string('condicion', 15)->nullable();
            $table->string('ubigeo', 6)->nullable();
            $table->string('tipo_via', 100)->nullable();
            $table->string('nombre_via', 100)->nullable();
            $table->string('codigo_zona', 30)->nullable();
            $table->string('tipo_zona', 100)->nullable();
            $table->string('numero', 20)->nullable();
            $table->string('interior', 50)->nullable();
            $table->string('lote', 50)->nullable();
            $table->string('departamento', 50)->nullable();
            $table->string('manzana', 50)->nullable();
            $table->string('kilometro', 50)->nullable();
            $table->tinyInteger('status')->default(1);
            $table->softDeletes();
            $table->timestamps();
            $table->unique(['company_id', 'ruc']);
        });
    }
};
