<?php

namespace App\Observers;

use App\Models\Orderformitem;
use App\Models\StockReservation;

class OrderformitemObserver
{
    /**
     * Handle the Orderformitem "created" event.
     */
    public function created(Orderformitem $orderformitem): void
    {
        $orderform = $orderformitem->orderform;
        if (!$orderform) return;

        StockReservation::create([
            'company_id' => $orderform->company_id,
            'warehouse_id' => $orderform->warehouse_id,
            'product_id' => $orderformitem->product_id,
            'orderform_id' => $orderform->id,
            'orderformitem_id' => $orderformitem->id,
            'quantity' => $orderformitem->quantity,
            'status' => 1, // 1: Reserved/Active
        ]);
    }

    /**
     * Handle the Orderformitem "updated" event.
     */
    public function updated(Orderformitem $orderformitem): void
    {
        $reservation = StockReservation::where('orderformitem_id', $orderformitem->id)->first();

        if ($reservation) {
            if ($orderformitem->isDirty('quantity')) {
                $reservation->update(['quantity' => $orderformitem->quantity]);
            }

            if ($orderformitem->isDirty('status')) {
                $statusInt = (int) $orderformitem->status;
                if ($statusInt === 4 || $statusInt === 0) {
                    $reservation->update(['status' => 0]); // 0: Released/Canceled
                } elseif ($statusInt === 3) {
                    $reservation->update(['status' => 2]); // 2: Consumed
                }
            }
        }
    }

    /**
     * Handle the Orderformitem "deleted" event.
     */
    public function deleted(Orderformitem $orderformitem): void
    {
        $reservation = StockReservation::where('orderformitem_id', $orderformitem->id)->first();
        if ($reservation) {
            $reservation->update(['status' => 0]); // 0: Released
        }
    }

    /**
     * Handle the Orderformitem "restored" event.
     */
    public function restored(Orderformitem $orderformitem): void
    {
        $reservation = StockReservation::where('orderformitem_id', $orderformitem->id)->first();
        if ($reservation) {
            $reservation->update(['status' => 1]); // 1: Active
        }
    }
}
