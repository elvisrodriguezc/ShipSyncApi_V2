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
        // 1. Remove stock and stockdependency_id from products table
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'stockdependency_id')) {
                $table->dropColumn('stockdependency_id');
            }
            if (Schema::hasColumn('products', 'stock')) {
                $table->dropColumn('stock');
            }
        });

        // 2. Add warehouse_id to batches table
        Schema::table('batches', function (Blueprint $table) {
            if (!Schema::hasColumn('batches', 'warehouse_id')) {
                $table->foreignId('warehouse_id')->nullable()->after('company_id')->constrained('warehouses')->onDelete('restrict')->onUpdate('cascade');
            }
        });

        // 3. Create product_stocks table
        if (!Schema::hasTable('product_stocks')) {
            Schema::create('product_stocks', function (Blueprint $table) {
                $table->id();
                $table->foreignId('company_id')->constrained('companies')->onDelete('cascade')->onUpdate('cascade');
                $table->foreignId('warehouse_id')->constrained('warehouses')->onDelete('cascade')->onUpdate('cascade');
                $table->foreignId('product_id')->constrained('products')->onDelete('cascade')->onUpdate('cascade');
                $table->decimal('stock_actual', 12, 4)->default(0);
                $table->softDeletes();
                $table->timestamps();

                $table->unique(['warehouse_id', 'product_id']);
                $table->index(['company_id', 'warehouse_id', 'product_id']);
            });
        }

        // 4. Create stock_reservations table
        if (!Schema::hasTable('stock_reservations')) {
            Schema::create('stock_reservations', function (Blueprint $table) {
                $table->id();
                $table->foreignId('company_id')->constrained('companies')->onDelete('cascade')->onUpdate('cascade');
                $table->foreignId('warehouse_id')->constrained('warehouses')->onDelete('cascade')->onUpdate('cascade');
                $table->foreignId('product_id')->constrained('products')->onDelete('cascade')->onUpdate('cascade');
                $table->foreignId('orderform_id')->constrained('orderforms')->onDelete('cascade')->onUpdate('cascade');
                $table->foreignId('orderformitem_id')->constrained('orderformitems')->onDelete('cascade')->onUpdate('cascade');
                $table->decimal('quantity', 12, 4)->default(0);
                $table->tinyInteger('status')->default(1)->comment('1: Reserved/Active, 0: Released/Canceled, 2: Consumed/Attended');
                $table->softDeletes();
                $table->timestamps();

                $table->index(['company_id', 'warehouse_id', 'product_id', 'status'], 'idx_stock_res_comp_wh_prod_st');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_reservations');
        Schema::dropIfExists('product_stocks');

        Schema::table('batches', function (Blueprint $table) {
            if (Schema::hasColumn('batches', 'warehouse_id')) {
                try {
                    $table->dropForeign(['warehouse_id']);
                } catch (\Exception $e) {}
                $table->dropColumn('warehouse_id');
            }
        });

        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'stock')) {
                $table->decimal('stock', 12, 4)->nullable();
            }
            if (!Schema::hasColumn('products', 'stockdependency_id')) {
                $table->foreignId('stockdependency_id')->nullable()->constrained('products')->onDelete('restrict')->onUpdate('cascade');
            }
        });
    }
};
