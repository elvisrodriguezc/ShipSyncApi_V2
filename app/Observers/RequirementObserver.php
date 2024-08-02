<?php

namespace App\Observers;

use App\Models\Numerator;
use App\Models\Requirement;
use App\Models\Warehouse;
use Illuminate\Support\Facades\Auth;

class RequirementObserver
{
    public function creating(Requirement $requirement): void
    {
        $user = Auth::user();
        $officeId = Warehouse::where('id', $user->warehouse_id)->pluck('office_id')->first();
        $numerator = Numerator::where('office_id', $officeId)
            ->where('description', 'Requerimiento')
            ->first();
        $requirement->company_id = $user->company_id;
        $requirement->warehouse_id = $user->warehouse_id;
        $requirement->user_id = $user->id;
        $requirement->numerator_id = $numerator->id;
        $requirement->number = $numerator->number + 1;
    }

    public function created(Requirement $requirement): void
    {
        $user = Auth::user();
        $officeId = Warehouse::where('id', $user->warehouse_id)->pluck('office_id')->first();
        $numerator = Numerator::where('office_id', $officeId)
            ->where('description', 'Requerimiento')
            ->first();
        if ($numerator) {
            $numerator->increment('number'); // Incrementar el número en 1
        }
    }

    /**
     * Handle the Requirement "updated" event.
     */
    public function updated(Requirement $requirement): void
    {
        //
    }

    /**
     * Handle the Requirement "deleted" event.
     */
    public function deleted(Requirement $requirement): void
    {
        //
    }

    /**
     * Handle the Requirement "restored" event.
     */
    public function restored(Requirement $requirement): void
    {
        //
    }

    /**
     * Handle the Requirement "force deleted" event.
     */
    public function forceDeleted(Requirement $requirement): void
    {
        //
    }
}
