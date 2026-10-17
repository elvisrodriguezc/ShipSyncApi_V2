<?php

namespace App\Observers;

use App\Models\Orderform;
use App\Models\Product;

class OrderformObserver
{
    /**
     * Handle the Orderform "created" event.
     */
    public function created(Orderform $orderform): void
    {
        //
    }

    /**
     * Handle the Orderform "updated" event.
     */
    public function updated(Orderform $orderform): void
    {
        if ($orderform->isDirty('status')) {
            $orderform->orderformitems()->update(['status' => $orderform->status]);

            $newStatus = (int) $orderform->status;
            $reservationStatus = 1; // Default 1: Reserved

            if ($newStatus === 4 || $newStatus === 0) {
                $reservationStatus = 0; // Released / Canceled
            } elseif ($newStatus === 3) {
                $reservationStatus = 2; // Consumed
            } elseif ($newStatus === 1 || $newStatus === 2) {
                $reservationStatus = 1; // Active
            }

            \App\Models\StockReservation::where('orderform_id', $orderform->id)
                ->update(['status' => $reservationStatus]);
        }
    }

    /**
     * Handle the Orderform "deleted" event.
     */
    public function deleted(Orderform $orderform): void
    {
        \App\Models\StockReservation::where('orderform_id', $orderform->id)
            ->update(['status' => 0]);
    }

    /**
     * Handle the Orderform "restored" event.
     */
    public function restored(Orderform $orderform): void
    {
        //
    }

    /**
     * Handle the Orderform "force deleted" event.
     */
    public function forceDeleted(Orderform $orderform): void
    {
        //
    }
}
