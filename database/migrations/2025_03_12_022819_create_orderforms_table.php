<?php

use App\Models\Typevalue;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function PHPSTORM_META\type;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orderforms', function (Blueprint $table) {
            $table->id();
            $table->timestamp('date')->nullable();
            $table->foreignId('company_id')->constrained()->update('cascade')->delete('restrict');
            $table->foreignId('headquarter_id')->constrained()->update('cascade')->delete('restrict');
            $table->foreignId('warehouse_id')->constrained()->update('cascade')->delete('restrict');
            $table->foreignId('user_id')->constrained()->update('cascade')->delete('restrict');
            $table->foreignId('contact_id')->constrained()->update('cascade')->delete('restrict');
            $table->foreignId('entity_id')->nullable()->constrained()->update('cascade')->delete('restrict');
            $table->foreignId('ordertype_id')->nullable()->constrained('typevalues')->update('cascade')->delete('restrict');
            $table->text('order_line')->nullable();
            $table->text('observation')->nullable();
            $table->timestamp('finished_at')->nullable();
            $table->unsignedTinyInteger('status')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orderforms');
    }
};
