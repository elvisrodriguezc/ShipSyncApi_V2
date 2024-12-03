<?php

namespace App\Observers;

use App\Models\Document;
use App\Models\Order;
use App\Models\Office;
use App\Models\Numerator;
use App\Models\Warehouse;
use Illuminate\Support\Facades\Auth;

class OrderObserver
{
    public function creating(Order $order)
    {
        // Aquí puedes realizar las acciones necesarias antes de crear el pedido
        $user = Auth::user();
        $warehouseId = $user->warehouse_id;
        $officeId = Warehouse::where('id', $warehouseId)->value('office_id');
        $document = Document::where('code', 'ORD')->first();
        $numerator = Numerator::where('office_id', $officeId)
            ->where('document_id', $document->id)
            ->first();

        if ($numerator) {
            $order->office_id = $officeId;
            $order->user_id = $user->id;
            $order->numerator_id = $numerator->id;
            $order->number = $numerator->number + 1;
        } else {
            dd('falló al buscar el Numerador');
        }
    }

    public function created(Order $order): void
    {
        $user = Auth::user();
        // Asumiendo que $user->warehouse_id tiene el id del almacén
        $warehouseId = $user->warehouse_id;
        $officeId = Warehouse::where('id', $warehouseId)->value('office_id');
        // Obtener los datos del documento ORDEN
        $document = Document::where('code', 'ORD')->first();
        $numerator = Numerator::where('office_id', $officeId)
            ->where('document_id', $document->id)
            ->first();
        if ($numerator) {
            $numerator->increment('number');
        }
    }

    /**
     * Handle the Order "updated" event.
     */
    public function updated(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "deleted" event.
     */
    public function deleted(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "restored" event.
     */
    public function restored(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     */
    public function forceDeleted(Order $order): void
    {
        //
    }
}
