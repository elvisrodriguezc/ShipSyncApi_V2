<?php

namespace App\Observers;

use App\Models\Transferdetail;

class TransferdetailObserver
{
    /**
     * Handle the Transferdetail "created" event.
     */
    public function created(Transferdetail $transferdetail): void
    {
        //
    }

    /**
     * Handle the Transferdetail "updated" event.
     */
    public function updated(Transferdetail $transferdetail): void
    {
        //
    }

    /**
     * Handle the Transferdetail "deleted" event.
     */
    public function deleted(Transferdetail $transferdetail): void
    {
        //
    }

    /**
     * Handle the Transferdetail "restored" event.
     */
    public function restored(Transferdetail $transferdetail): void
    {
        //
    }

    /**
     * Handle the Transferdetail "force deleted" event.
     */
    public function forceDeleted(Transferdetail $transferdetail): void
    {
        //
    }
}
