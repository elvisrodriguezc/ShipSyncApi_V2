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

        if ($product->stockdependency_id) {
            $product->stockdependency->decrement('stock', $orderformitem->quantity);
        } else {
            $product->decrement('stock', $orderformitem->quantity);
        }
    }

    /**
     * Handle the Orderformitem "updated" event.
     */
    public function updated(Orderformitem $orderformitem): void
    {
        if ($orderformitem->isDirty('quantity')) {
            $diff = (float)$orderformitem->quantity - (float)$orderformitem->getOriginal('quantity');
            $product = $orderformitem->product;

            if ($product->stockdependency_id) {
                $product->stockdependency->decrement('stock', $diff);
            } else {
                $product->decrement('stock', $diff);
            }
        }

        if ($orderformitem->isDirty('status')) {
            if ((int)$orderformitem->status === 4) {
                $product = $orderformitem->product;

                if ($product->stockdependency_id) {
                    $product->stockdependency->increment('stock', $orderformitem->quantity);
                } else {
                    $product->increment('stock', $orderformitem->quantity);
                }
            }
        }
    }

    /**
     * Handle the Orderformitem "deleted" event.
     */
    public function deleted(Orderformitem $orderformitem): void
    {
        if (in_array((int)$orderformitem->status, [1, 2])) {
            $product = $orderformitem->product;

            if ($product->stockdependency_id) {
                $product->stockdependency->increment('stock', $orderformitem->quantity);
            } else {
                $product->increment('stock', $orderformitem->quantity);
            }
        }
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
