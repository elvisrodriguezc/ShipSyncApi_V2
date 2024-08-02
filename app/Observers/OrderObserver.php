<?php

namespace App\Observers;

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
        $officeId = Warehouse::where('id', $user->warehouse_id)->pluck('office_id')->first();

        $numerator = Numerator::where('office_id', $officeId)
            ->where('documenttype_id', 7)
            ->first();

        $order->office_id = $officeId;
        $order->user_id = $user->id;
        $order->numerator_id = $numerator->id;
        $order->number = $numerator->number + 1;
    }

    public function created(Order $order): void
    {
        $user = Auth::user();
        $officeId = Office::where('company_id', $user->company_id)->value('id');
        $numerator = Numerator::where('office_id', $officeId)
            ->where('documenttype_id', 7)
            ->first();

        if ($numerator) {
            $numerator->increment('number'); // Incrementar el número en 1
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
