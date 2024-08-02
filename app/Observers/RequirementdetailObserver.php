<?php

namespace App\Observers;

use App\Models\Requirementdetail;
use Illuminate\Support\Facades\Auth;

class RequirementdetailObserver
{
    public function creating(Requirementdetail $requirementdetail): void
    {
        $user = Auth::user();
        $requirementdetail->updatedby_id = $user->id;
    }
    public function created(Requirementdetail $requirementdetail): void
    {
        //
    }

    /**
     * Handle the Requirementdetail "updated" event.
     */
    public function updated(Requirementdetail $requirementdetail): void
    {
        //
    }

    /**
     * Handle the Requirementdetail "deleted" event.
     */
    public function deleted(Requirementdetail $requirementdetail): void
    {
        //
    }

    /**
     * Handle the Requirementdetail "restored" event.
     */
    public function restored(Requirementdetail $requirementdetail): void
    {
        //
    }

    /**
     * Handle the Requirementdetail "force deleted" event.
     */
    public function forceDeleted(Requirementdetail $requirementdetail): void
    {
        //
    }
}
