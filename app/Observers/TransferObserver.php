<?php

namespace App\Observers;

use App\Models\Numerator;
use App\Models\Transfer;
use App\Models\Warehouse;
use Illuminate\Support\Facades\Auth;

class TransferObserver
{
    public function creating(Transfer $transfer): void
    {
        $user = Auth::user();
        $officeId = Warehouse::where('id', $user->warehouse_id)->pluck('office_id')->first();
        $numerator = Numerator::where('office_id', $officeId)
            ->where('documenttype_id', 53)
            ->first();
        $transfer->company_id = $user->company_id;
        $transfer->user_id = $user->id;
        $transfer->numerator_id = $numerator->id;
        $transfer->number = $numerator->number + 1;
    }
    public function created(Transfer $transfer): void
    {
        $user = Auth::user();
        $officeId = Warehouse::where('id', $user->warehouse_id)->pluck('office_id')->first();
        $numerator = Numerator::where('office_id', $officeId)
            ->where('documenttype_id', 53)
            ->first();

        if ($numerator) {
            $numerator->increment('number'); // Incrementar el número en 1
        }
    }

    /**
     * Handle the Transfer "updated" event.
     */
    public function updated(Transfer $transfer): void
    {
        //
    }

    /**
     * Handle the Transfer "deleted" event.
     */
    public function deleted(Transfer $transfer): void
    {
        //
    }

    /**
     * Handle the Transfer "restored" event.
     */
    public function restored(Transfer $transfer): void
    {
        //
    }

    /**
     * Handle the Transfer "force deleted" event.
     */
    public function forceDeleted(Transfer $transfer): void
    {
        //
    }
}
