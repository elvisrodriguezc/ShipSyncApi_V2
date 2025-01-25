<?php

namespace App\Observers;

use App\Models\Producttax;

class ProducttaxObserver
{
    /**
     * Handle the Producttax "created" event.
     */
    public function created(Producttax $producttax): void
    {
        //
    }

    /**
     * Handle the Producttax "updated" event.
     */
    public function updated(Producttax $producttax): void
    {
        //
    }

    /**
     * Handle the Producttax "deleted" event.
     */
    public function deleted(Producttax $producttax): void
    {
        //
    }

    /**
     * Handle the Producttax "restored" event.
     */
    public function restored(Producttax $producttax): void
    {
        //
    }

    /**
     * Handle the Producttax "force deleted" event.
     */
    public function forceDeleted(Producttax $producttax): void
    {
        //
    }
}
