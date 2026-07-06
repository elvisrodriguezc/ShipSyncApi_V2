<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('purchases', function (Blueprint $table) {
            try {
                $table->dropUnique('purchases_unique_comprobante');
            } catch (\Exception $e) {
                // Ignore if it doesn't exist
            }
            if (Schema::hasColumn('purchases', 'active_status')) {
                $table->dropColumn('active_status');
            }
        });
    }

    public function down(): void
    {
        // No rollback needed
    }
};
