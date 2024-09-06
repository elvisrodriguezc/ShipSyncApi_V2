<?php

namespace App\Observers;

use App\Models\Productaccesory;

class ProductaccesoryObserver
{
    /**
     * Handle the Productaccesory "created" event.
     */
    public function created(Productaccesory $productaccesory): void
    {
        //
    }

    /**
     * Handle the Productaccesory "updated" event.
     */
    public function updated(Productaccesory $productaccesory): void
    {
        //
    }

    /**
     * Handle the Productaccesory "deleted" event.
     */
    public function deleted(Productaccesory $productaccesory): void
    {
        //
    }

    /**
     * Handle the Productaccesory "restored" event.
     */
    public function restored(Productaccesory $productaccesory): void
    {
        //
    }

    /**
     * Handle the Productaccesory "force deleted" event.
     */
    public function forceDeleted(Productaccesory $productaccesory): void
    {
        //
    }
}
