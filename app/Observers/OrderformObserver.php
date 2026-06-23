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
