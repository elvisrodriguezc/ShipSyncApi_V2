<?php

namespace App\Observers;

use App\Models\Vcandidate;

class VcandidateObserver
{
    /**
     * Handle the Vcandidate "created" event.
     */
    public function created(Vcandidate $vcandidate): void
    {
        //
    }

    /**
     * Handle the Vcandidate "updated" event.
     */
    public function updated(Vcandidate $vcandidate): void
    {
        //
    }

    /**
     * Handle the Vcandidate "deleted" event.
     */
    public function deleted(Vcandidate $vcandidate): void
    {
        //
    }

    /**
     * Handle the Vcandidate "restored" event.
     */
    public function restored(Vcandidate $vcandidate): void
    {
        //
    }

    /**
     * Handle the Vcandidate "force deleted" event.
     */
    public function forceDeleted(Vcandidate $vcandidate): void
    {
        //
    }
}
