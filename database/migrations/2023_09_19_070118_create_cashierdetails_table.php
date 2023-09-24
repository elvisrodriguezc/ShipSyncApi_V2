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
        Schema::create('cashierdetails', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cashier_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('paymethod_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->decimal('amount', 8, 2);
            $table->text('op_number', 15);
            $table->datetime('date_time');
            $table->text('description');
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cashierdetails');
    }
};
