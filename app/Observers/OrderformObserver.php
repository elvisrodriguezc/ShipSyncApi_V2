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
            if ((int)$orderform->status === 4) {
                foreach ($orderform->orderformitems as $item) {
                    $product = $item->product;
                    if ($product->stockdependency_id) {
                        $productStock = Product::where('id', $product->stockdependency_id)->first();
                        $productStock->stock += $item->quantity;
                        $productStock->save();
                    } else {
                        $product->stock += $item->quantity;
                        $product->save();
                    }
                }
            }
            $orderform->orderformitems()->update(['status' => $orderform->status]);
        }
    }

    /**
     * Handle the Orderform "deleted" event.
     */
    public function deleted(Orderform $orderform): void
    {
        //
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
