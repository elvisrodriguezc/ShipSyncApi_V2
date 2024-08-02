<?php

namespace App\Observers;

use App\Models\Guidecarrier;
use App\Models\Numerator;
use App\Models\Warehouse;
use Illuminate\Support\Facades\Auth;

class GuidecarrierObserver
{
    /**
     * Handle the Guidecarrier "created" event.
     */
    public function creating(Guidecarrier $guidecarrier): void
    {
        $user = Auth::user();
        $officeId = Warehouse::where('id', $user->warehouse_id)->pluck('office_id')->first();
        $numerator = Numerator::where('office_id', $officeId)
            ->where('documenttype_id', 49)
            ->first();
        $guidecarrier->user_id = $user->id;
        $guidecarrier->company_id = $user->company_id;
        $guidecarrier->numerator_id = $numerator->id;
        $guidecarrier->number = $numerator->number + 1;
    }

    public function created(Guidecarrier $guidecarrier): void
    {
        $user = Auth::user();
        $officeId = Warehouse::where('id', $user->warehouse_id)->pluck('office_id')->first();
        $numerator = Numerator::where('office_id', $officeId)
            ->where('documenttype_id', 49)
            ->first();
        if ($numerator) {
            $numerator->increment('number'); // Incrementar el número en 1
        }
    }

    /**
     * Handle the Guidecarrier "updated" event.
     */
    public function updated(Guidecarrier $guidecarrier): void
    {
        //
    }

    /**
     * Handle the Guidecarrier "deleted" event.
     */
    public function deleted(Guidecarrier $guidecarrier): void
    {
        //
    }

    /**
     * Handle the Guidecarrier "restored" event.
     */
    public function restored(Guidecarrier $guidecarrier): void
    {
        //
    }

    /**
     * Handle the Guidecarrier "force deleted" event.
     */
    public function forceDeleted(Guidecarrier $guidecarrier): void
    {
        //
    }
}
