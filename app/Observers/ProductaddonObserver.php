<?php

namespace App\Observers;

use App\Models\Productaddon;

class ProductaddonObserver
{
    /**
     * Handle the Productaddon "created" event.
     */
    public function created(Productaddon $productaddon): void
    {
        //
    }

    /**
     * Handle the Productaddon "updated" event.
     */
    public function updated(Productaddon $productaddon): void
    {
        //
    }

    /**
     * Handle the Productaddon "deleted" event.
     */
    public function deleted(Productaddon $productaddon): void
    {
        //
    }

    /**
     * Handle the Productaddon "restored" event.
     */
    public function restored(Productaddon $productaddon): void
    {
        //
    }

    /**
     * Handle the Productaddon "force deleted" event.
     */
    public function forceDeleted(Productaddon $productaddon): void
    {
        //
    }
}
