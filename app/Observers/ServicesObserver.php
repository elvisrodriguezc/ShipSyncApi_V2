<?php

namespace App\Observers;

use App\Models\Document;
use App\Models\Numerator;
use App\Models\Services;
use App\Models\Warehouse;
use Illuminate\Support\Facades\Auth;

class ServicesObserver
{
    public function creating(Services $services): void
    {
        $user = Auth::user();
        // Asumiendo que $user->warehouse_id tiene el id del almacén
        $warehouseId = $user->warehouse_id;
        $officeId = Warehouse::where('id', $warehouseId)->value('office_id');
        // Obtener los datos del documento Programa
        $document = Document::where('code', 'PRG')->first();
        $numerator = Numerator::where('office_id', $officeId)
            ->where('document_id', $document->id)
            ->first();

        $services->company_id = $user->company_id;
        $services->user_id = $user->id;
        if ($numerator) {
            $services->numerator_id = $numerator->id;
            $services->number = $numerator->number;
        } else {
            dd('Fallo al buscar el Numerador');
        }
    }

    public function created(Services $services): void
    {
        $user = Auth::user();
        // Asumiendo que $user->warehouse_id tiene el id del almacén
        $warehouseId = $user->warehouse_id;
        $officeId = Warehouse::where('id', $warehouseId)->value('office_id');
        // Obtener los datos del documento Programa
        $document = Document::where('code', 'PRG')->first();
        $numerator = Numerator::where('office_id', $officeId)
            ->where('document_id', $document->id)
            ->first();
        if ($numerator) {
            $numerator->increment('number');
        }
    }

    /**
     * Handle the Services "updated" event.
     */
    public function updated(Services $services): void
    {
        //
    }

    /**
     * Handle the Services "deleted" event.
     */
    public function deleted(Services $services): void
    {
        //
    }

    /**
     * Handle the Services "restored" event.
     */
    public function restored(Services $services): void
    {
        //
    }

    /**
     * Handle the Services "force deleted" event.
     */
    public function forceDeleted(Services $services): void
    {
        //
    }
}
