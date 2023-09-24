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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('name');
            $table->text('detail');
            $table->text('barcode')->nullable();
            $table->foreignId('category_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('unity_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('model')->nullable();
            $table->string('url');
            $table->string('image');
            $table->string('set_mode', 10);
            $table->foreignId('currency_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->decimal('price', 8, 2);
            $table->decimal('minimal', 8, 2);
            $table->foreignId('brand_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('taxmode_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('unspsc_id')
                ->nullable()
                ->default(1)
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
            $table->unique(['company_id', 'name']); // adds unicity restricxtion to the fields company_id and name
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
