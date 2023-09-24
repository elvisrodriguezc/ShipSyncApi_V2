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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('warehouse_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('entity_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('receipttype_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('document_serial', 10);
            $table->integer('document_number');
            $table->string('guide_number', 20)->nullable();
            $table->date('date');
            $table->boolean('credit');
            $table->date('duedate')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
