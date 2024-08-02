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
        Schema::create('orderserviceitems', function (Blueprint $table) {
            $table->id();
            $table->foreignId('orderservice_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreignId('orderitem_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->unsignedBigInteger('updateby_id');
            $table->string('note')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
            $table->foreign('updateby_id')->references('id')->on('typevalues')->onUpdate('CASCADE')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orderserviceitems');
    }
};
