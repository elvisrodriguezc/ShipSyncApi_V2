<?php

namespace App\Observers;

use App\Models\Orderformitem;
use App\Models\Product;

class OrderformitemObserver
{
    /**
     * Handle the Orderformitem "created" event.
     */
    public function created(Orderformitem $orderformitem): void
    {
        $product = $orderformitem->product;
        if ($product->stockdependency_id) {
            $productStock = Product::where('id', $product->stockdependency_id)->first();
            $productStock->stock -= $orderformitem->quantity;
            $productStock->save();
        } else {
            $product->stock -= $orderformitem->quantity;
            $product->save();
        }
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
