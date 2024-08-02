<?php

namespace App\Observers;

use App\Models\Numerator;
use App\Models\Purchase;
use App\Models\Warehouse;
use Illuminate\Support\Facades\Auth;

class PurchaseObserver
{
    public function creating(Purchase $purchase): void
    {
        $user = Auth::user();
        $officeId = Warehouse::where('id', $user->warehouse_id)->pluck('office_id')->first();
        $numerator = Numerator::where('office_id', $officeId)
            ->where('documenttype_id', 51)
            ->first();
        $purchase->user_id = $user->id;
        $purchase->company_id = $user->company_id;
        $purchase->numerator_id = $numerator->id;
        $purchase->number = $numerator->number + 1;
    }

    public function created(Purchase $purchase): void
    {
        $user = Auth::user();
        $officeId = Warehouse::where('id', $user->warehouse_id)->pluck('office_id')->first();
        $numerator = Numerator::where('office_id', $officeId)
            ->where('documenttype_id', 51)
            ->first();
        if ($numerator) {
            $numerator->increment('number'); // Incrementar el número en 1
        }
    }

    /**
     * Handle the Purchase "updated" event.
     */
    public function updated(Purchase $purchase): void
    {
        //
    }

    /**
     * Handle the Purchase "deleted" event.
     */
    public function deleted(Purchase $purchase): void
    {
        //
    }

    /**
     * Handle the Purchase "restored" event.
     */
    public function restored(Purchase $purchase): void
    {
        //
    }

    /**
     * Handle the Purchase "force deleted" event.
     */
    public function forceDeleted(Purchase $purchase): void
    {
        //
    }
}
