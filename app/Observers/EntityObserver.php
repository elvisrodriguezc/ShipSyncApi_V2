<?php

namespace App\Observers;

use App\Models\Entity;
use Illuminate\Support\Facades\Auth;

class EntityObserver
{
    public function creating(Entity $entity): void
    {
        $user = Auth::user();
        $entity->company_id = $user->company_id;
    }
    public function created(Entity $entity): void
    {
        //
    }

    /**
     * Handle the Entity "updated" event.
     */
    public function updated(Entity $entity): void
    {
        //
    }

    /**
     * Handle the Entity "deleted" event.
     */
    public function deleted(Entity $entity): void
    {
        //
    }

    /**
     * Handle the Entity "restored" event.
     */
    public function restored(Entity $entity): void
    {
        //
    }

    /**
     * Handle the Entity "force deleted" event.
     */
    public function forceDeleted(Entity $entity): void
    {
        //
    }
}
