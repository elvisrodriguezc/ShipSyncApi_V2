<?php

namespace App\Observers;

use App\Models\Orderformitem;

class OrderformitemObserver
{
    /**
     * Handle the Orderformitem "created" event.
     */
    public function created(Orderformitem $orderformitem): void
    {
        $product = $orderformitem->product;
        $product->stock -= $orderformitem->quantity;
        $product->save();
    }

    /**
     * Handle the Orderformitem "updated" event.
     */
    public function updated(Orderformitem $orderformitem): void
    {
        //
    }

    /**
     * Handle the Orderformitem "deleted" event.
     */
    public function deleted(Orderformitem $orderformitem): void
    {
        //
    }

    /**
     * Handle the Orderformitem "restored" event.
     */
    public function restored(Orderformitem $orderformitem): void
    {
        //
    }

    /**
     * Handle the Orderformitem "force deleted" event.
     */
    public function forceDeleted(Orderformitem $orderformitem): void
    {
        //
    }
}
