<?php

namespace App\Observers;

use App\Models\Orderservice;
use App\Models\Orderserviceitem;

class OrderserviceitemObserver
{
    /**
     * Handle the Orderserviceitem "created" event.
     */
    public function created(Orderserviceitem $orderserviceitem): void {}

    /**
     * Handle the Orderserviceitem "updated" event.
     */
    public function updated(Orderserviceitem $orderserviceitem): void
    {
        $orderServiceId = $orderserviceitem->orderservice_id;
        // Verificar si todos los registros de Orderserviceitem tienen status = 3
        $allItemsCompleted = Orderserviceitem::where('orderservice_id', $orderServiceId)
            ->where('status', '!=', 3)
            ->doesntExist();

        // dd($allItemsCompleted);
        if ($allItemsCompleted) {
            // Actualizar el estado de orderservice a 3
            Orderservice::where('id', $orderServiceId)->update(['status' => 3]);
        }
    }
    // protected function checkAndUpdateOrderServiceStatus(Orderserviceitem $orderserviceitem): void
    // {
    //     $orderServiceId = $orderserviceitem->orderservice_id;
    //     // Verificar si todos los registros de Orderserviceitem tienen status = 3
    //     $allItemsCompleted = Orderserviceitem::where('orderservice_id', $orderServiceId)
    //         ->where('status', '!=', 3)
    //         ->doesntExist();

    //     if ($allItemsCompleted) {
    //         // Actualizar el estado de orderservice a 3
    //         Orderservice::where('id', $orderServiceId)->update(['status' => 3]);
    //     }
    // }

    /**
     * Handle the Orderserviceitem "deleted" event.
     */
    public function deleted(Orderserviceitem $orderserviceitem): void
    {
        //
    }

    /**
     * Handle the Orderserviceitem "restored" event.
     */
    public function restored(Orderserviceitem $orderserviceitem): void
    {
        //
    }

    /**
     * Handle the Orderserviceitem "force deleted" event.
     */
    public function forceDeleted(Orderserviceitem $orderserviceitem): void
    {
        //
    }
}
