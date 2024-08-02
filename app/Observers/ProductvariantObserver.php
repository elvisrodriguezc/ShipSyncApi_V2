<?php

namespace App\Observers;

use App\Models\Productvariant;

class ProductvariantObserver
{
    /**
     * Handle the Productvariant "created" event.
     */
    public function created(Productvariant $productvariant): void
    {
        //
    }

    /**
     * Handle the Productvariant "updated" event.
     */
    public function updated(Productvariant $productvariant): void
    {
        //
    }

    /**
     * Handle the Productvariant "deleted" event.
     */
    public function deleted(Productvariant $productvariant): void
    {
        //
    }

    /**
     * Handle the Productvariant "restored" event.
     */
    public function restored(Productvariant $productvariant): void
    {
        //
    }

    /**
     * Handle the Productvariant "force deleted" event.
     */
    public function forceDeleted(Productvariant $productvariant): void
    {
        //
    }
}
