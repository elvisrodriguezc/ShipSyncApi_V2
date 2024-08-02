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
            $table->foreignId('company_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreignId('warehouse_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreignId('user_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreignId('numerator_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->unsignedInteger('number');
            $table->foreignId('entity_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->unsignedBigInteger('receipttype_id');
            $table->string('document_serial', 10);
            $table->integer('document_number');
            $table->string('guide_number', 20)->nullable();
            $table->date('date');
            $table->boolean('credit')->default(0);
            $table->date('duedate')->nullable();
            $table->boolean('taxincluded')->default(0);
            $table->tinyInteger('status')->default(1);
            $table->foreign('receipttype_id')->references('id')->on('typevalues')->onUpdate('CASCADE')->onDelete('RESTRICT');
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
