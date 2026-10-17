<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('id_card_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('code', 20);
            $table->timestamps();
        });

        DB::table('id_card_types')->insert([
            ['name' => 'DNI', 'code' => 'DNI', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Carnet de Extranjería', 'code' => 'CE', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Pasaporte', 'code' => 'PAS', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'RUC', 'code' => 'RUC', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('id_card_types');
    }
};
