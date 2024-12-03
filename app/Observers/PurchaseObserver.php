<?php

namespace App\Observers;

use App\Models\Document;
use App\Models\Numerator;
use App\Models\Purchase;
use App\Models\Warehouse;
use Illuminate\Support\Facades\Auth;

class PurchaseObserver
{
    public function creating(Purchase $purchase): void
    {
        $user = Auth::user();
        $warehouseId = $user->warehouse_id;
        $officeId = Warehouse::where('id', $warehouseId)->value('office_id');
        $document = Document::where('code', 'PUR')->first();
        $numerator = Numerator::where('office_id', $officeId)
            ->where('document_id', $document->id)
            ->first();
        if ($numerator) {
            $purchase->company_id = $user->company_id;
            $purchase->warehouse_id = $user->warehouse_id;
            $purchase->user_id = $user->id;
            $purchase->numerator_id = $numerator->id;
            $purchase->number = $numerator->number + 1;
        } else {
            dd('Numerodor no encontrado');
        }
    }

    public function created(Purchase $purchase): void
    {
        $user = Auth::user();
        $warehouseId = $user->warehouse_id;
        $officeId = Warehouse::where('id', $warehouseId)->value('office_id');
        $document = Document::where('code', 'PUR')->first();
        $numerator = Numerator::where('office_id', $officeId)
            ->where('document_id', $document->id)
            ->first();
        if ($numerator) {
            $numerator->increment('number');
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
