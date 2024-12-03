<?php

namespace App\Observers;

use App\Models\Document;
use App\Models\Numerator;
use App\Models\Servicedetail;
use App\Models\Warehouse;
use Illuminate\Support\Facades\Auth;

class ServicedetailObserver
{
    /**
     * Handle the Servicedetail "created" event.
     */
    public function creating(Servicedetail $servicedetail): void
    {
        $user = Auth::user();
        // Asumiendo que $user->warehouse_id tiene el id del almacén
        $warehouseId = $user->warehouse_id;
        $officeId = Warehouse::where('id', $warehouseId)->value('office_id');
        // Obtener los datos del documento Programa
        $document = Document::where('code', 'SRV')->first();
        $numerator = Numerator::where('office_id', $officeId)
            ->where('document_id', $document->id)
            ->first();

        if ($numerator) {
            $servicedetail->numerator_id = $numerator->id;
            $servicedetail->number = $numerator->number;
        } else {
            dd('Fallo al buscar el Numerador');
        }
    }

    public function created(Servicedetail $servicedetail): void
    {
        $user = Auth::user();
        // Asumiendo que $user->warehouse_id tiene el id del almacén
        $warehouseId = $user->warehouse_id;
        $officeId = Warehouse::where('id', $warehouseId)->value('office_id');
        // Obtener los datos del documento Programa
        $document = Document::where('code', 'SRV')->first();
        $numerator = Numerator::where('office_id', $officeId)
            ->where('document_id', $document->id)
            ->first();

        if ($numerator) {
            $numerator->increment('number');
        }
    }

    /**
     * Handle the Servicedetail "updated" event.
     */
    public function updated(Servicedetail $servicedetail): void
    {
        //
    }

    /**
     * Handle the Servicedetail "deleted" event.
     */
    public function deleted(Servicedetail $servicedetail): void
    {
        //
    }

    /**
     * Handle the Servicedetail "restored" event.
     */
    public function restored(Servicedetail $servicedetail): void
    {
        //
    }

    /**
     * Handle the Servicedetail "force deleted" event.
     */
    public function forceDeleted(Servicedetail $servicedetail): void
    {
        //
    }
}
