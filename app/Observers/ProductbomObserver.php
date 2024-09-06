<?php

namespace App\Observers;

use App\Models\Productbom;

class ProductbomObserver
{
    /**
     * Handle the Productbom "created" event.
     */
    public function created(Productbom $productbom): void
    {
        //
    }

    /**
     * Handle the Productbom "updated" event.
     */
    public function updated(Productbom $productbom): void
    {
        //
    }

    /**
     * Handle the Productbom "deleted" event.
     */
    public function deleted(Productbom $productbom): void
    {
        //
    }

    /**
     * Handle the Productbom "restored" event.
     */
    public function restored(Productbom $productbom): void
    {
        //
    }

    /**
     * Handle the Productbom "force deleted" event.
     */
    public function forceDeleted(Productbom $productbom): void
    {
        //
    }
}
