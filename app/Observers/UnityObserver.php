<?php

namespace App\Observers;

use App\Models\Unity;
use Illuminate\Support\Facades\Auth;

class UnityObserver
{
    public function creating(Unity $unity): void
    {
    }

    public function created(Unity $unity): void
    {
        //
    }

    /**
     * Handle the Unity "updated" event.
     */
    public function updated(Unity $unity): void
    {
        //
    }

    /**
     * Handle the Unity "deleted" event.
     */
    public function deleted(Unity $unity): void
    {
        //
    }

    /**
     * Handle the Unity "restored" event.
     */
    public function restored(Unity $unity): void
    {
        //
    }

    /**
     * Handle the Unity "force deleted" event.
     */
    public function forceDeleted(Unity $unity): void
    {
        //
    }
}
