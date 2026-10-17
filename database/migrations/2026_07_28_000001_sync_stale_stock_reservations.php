<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('stock_reservations')) {
            // Update stock_reservations status to 0 (Released) for orderforms that are Canceled (4)
            DB::statement("
                UPDATE stock_reservations sr
                INNER JOIN orderforms o ON sr.orderform_id = o.id
                SET sr.status = 0
                WHERE o.status = 4
            ");

            // Update stock_reservations status to 2 (Consumed) for orderforms that are Attended (3)
            DB::statement("
                UPDATE stock_reservations sr
                INNER JOIN orderforms o ON sr.orderform_id = o.id
                SET sr.status = 2
                WHERE o.status = 3
            ");

            // Delete / release reservations whose orderformitem no longer exists
            DB::statement("
                UPDATE stock_reservations sr
                LEFT JOIN orderformitems oi ON sr.orderformitem_id = oi.id
                SET sr.status = 0
                WHERE oi.id IS NULL
            ");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No reversal needed for data sync
    }
};
