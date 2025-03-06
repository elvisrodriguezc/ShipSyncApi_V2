<?php

namespace App\Observers;

use App\Models\Document;
use App\Models\Numerator;
use App\Models\Programation;

class ProgramationObserver
{
    /**
     * Handle the Programation "creating" event.
     */
    public function creating(Programation $programation): void
    {
        $user = auth()->user();
        $document_id = Document::where('code', 'PRG')->first()->id;
        $numerator = Numerator::where('headquarter_id', $user->headquarter_id)
            ->where('document_id', $document_id)
            ->first();
        $programation->user_id = $user->id;
        $programation->company_id = $user->company_id;
        $programation->numerator_id = $numerator->id;
        $programation->number = $numerator->number;
    }

    /**
     * Handle the Programation "created" event.
     */
    public function created(Programation $programation): void
    {
        $numerator = Numerator::find($programation->numerator_id);
        $numerator->increment('number');
    }

    /**
     * Handle the Programation "updated" event.
     */
    public function updated(Programation $programation): void
    {
        //
    }

    /**
     * Handle the Programation "deleted" event.
     */
    public function deleted(Programation $programation): void
    {
        //
    }

    /**
     * Handle the Programation "restored" event.
     */
    public function restored(Programation $programation): void
    {
        //
    }

    /**
     * Handle the Programation "force deleted" event.
     */
    public function forceDeleted(Programation $programation): void
    {
        //
    }
}
