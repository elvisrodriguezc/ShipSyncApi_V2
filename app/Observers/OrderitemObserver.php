<?php

namespace App\Observers;

use App\Models\Orderitem;
use App\Models\Orderservice;
use App\Models\Orderserviceitem;
use App\Models\Tariffitem;
use Illuminate\Support\Facades\Auth;

class OrderitemObserver
{
    /**
     * Handle the Orderitem "created" event.
     */
    public function created(Orderitem $orderitem): void
    {
        $user = Auth::user();
        $warehouseId = Tariffitem::where('id', $orderitem->tariffitem_id)->value('warehouse_id');

        $orderService = Orderservice::firstOrCreate([
            'order_id' => $orderitem->order_id,
            'warehouse_id' => $warehouseId,
            'status' => 1,
        ], [
            'updateby_id' => $user->id,
        ]);
        Orderserviceitem::create([
            'orderservice_id' => $orderService->id,
            'orderitem_id' => $orderitem->id,
            'updateby_id' => $user->id
        ]);
    }


    /**
     * Handle the Orderitem "updated" event.
     */
    public function updated(Orderitem $orderitem): void
    {
        //
    }

    /**
     * Handle the Orderitem "deleted" event.
     */
    public function deleted(Orderitem $orderitem): void
    {
        //
    }

    /**
     * Handle the Orderitem "restored" event.
     */
    public function restored(Orderitem $orderitem): void
    {
        //
    }

    /**
     * Handle the Orderitem "force deleted" event.
     */
    public function forceDeleted(Orderitem $orderitem): void
    {
        //
    }
}
