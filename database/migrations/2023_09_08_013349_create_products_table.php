<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')
                ->constrained()
                ->onUpdate('CASCADE')
                ->onDelete('RESTRICT');
            $table->string('name');
            $table->text('detail');
            $table->text('barcode')
                ->nullable();
            $table->foreignId('category_id')
                ->constrained()
                ->onUpdate('CASCADE')
                ->onDelete('RESTRICT');
            $table->foreignId('unity_id')
                ->constrained()
                ->onUpdate('CASCADE')
                ->onDelete('RESTRICT');
            $table->foreignId('brand_id')
                ->nullable()
                ->constrained()
                ->onUpdate('CASCADE')
                ->onDelete('RESTRICT');
            $table->string('model')
                ->nullable();
            $table->string('url')
                ->nullable();
            $table->string('image');
            $table->string('set_mode', 10);
            $table->foreignId('currency_id')
                ->constrained()
                ->default(1)
                ->onUpdate('CASCADE')
                ->onDelete('RESTRICT');
            $table->decimal('price', 8, 2)
                ->default(0);
            $table->decimal('minimal', 8, 2)
                ->default(1);
            $table->foreignId('unspsc_id')
                ->nullable()
                ->constrained()
                ->onUpdate('CASCADE')
                ->onDelete('RESTRICT');
            $table->text('content')
                ->nullable();
            $table->decimal('weight', 8, 2)
                ->nullable();
            $table->decimal('height', 8, 2)
                ->nullable();
            $table->decimal('length', 8, 2)
                ->nullable();
            $table->decimal('width', 8, 2)
                ->nullable();
            $table->foreignId('condition_id')
                ->nullable()
                ->constrained('typevalues')
                ->onUpdate('CASCADE')
                ->onDelete('RESTRICT');
            $table->foreignId('warrantytype_id')
                ->nullable()
                ->constrained('typevalues')
                ->onUpdate('CASCADE')
                ->onDelete('RESTRICT');
            $table->integer('warrantymonths')
                ->nullable();
            $table->integer('depreciationmonths')
                ->nullable();
            $table->tinyInteger('status')
                ->default(1);
            $table->timestamps();
            $table->unique(['company_id', 'name', 'unity_id']); // adds unicity restriction to the fields company_id and name
            $table->unique(['company_id', 'barcode']); // adds unicity restriction to the fields company_id and name
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
