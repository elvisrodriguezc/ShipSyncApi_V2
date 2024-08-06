<?php

namespace App\Observers;

use App\Models\Warehouse;
use App\Models\Warehousekardex;
use App\Models\Warehousestock;
use Illuminate\Support\Facades\Auth;

class WarehousekardexObserver
{
    public function creating(Warehousekardex $warehousekardex): void
    {
        $user = Auth::user();
        $warehousekardex->user_id = $user->id;
        $warehousekardex->company_id = $user->company_id;
    }

    public function created(Warehousekardex $warehousekardex): void
    {
        $existingProduct = Warehousestock::where('warehouse_id', $warehousekardex->warehouse_id)
            ->where('product_id', $warehousekardex->product_id)
            ->first();
        $roundedPrice = round($warehousekardex->price, 4); // Limitar a 4 dígitos decimales

        if ($existingProduct) {
            // El producto ya existe, actualiza stock y precio
            $existingProduct->stock = $warehousekardex->stock;
            $existingProduct->price = $roundedPrice;
            $existingProduct->save();
        } else {
            // El producto no existe, crea un nuevo registro
            $officeId = Warehouse::find($warehousekardex->warehouse_id)->value('office_id');
            Warehousestock::create([
                'company_id' => $warehousekardex->company_id,
                'office_id' => $officeId,
                'warehouse_id' => $warehousekardex->warehouse_id,
                'product_id' => $warehousekardex->product_id,
                'stock' => $warehousekardex->stock,
                'price' => $roundedPrice,
                'reserved' => 0,
                'infinity' => 0,
            ]);
        }
    }


    /**
     * Handle the Warehousekardex "updated" event.
     */
    public function updated(Warehousekardex $warehousekardex): void
    {
        //
    }

    /**
     * Handle the Warehousekardex "deleted" event.
     */
    public function deleted(Warehousekardex $warehousekardex): void
    {
        //
    }

    /**
     * Handle the Warehousekardex "restored" event.
     */
    public function restored(Warehousekardex $warehousekardex): void
    {
        //
    }

    /**
     * Handle the Warehousekardex "force deleted" event.
     */
    public function forceDeleted(Warehousekardex $warehousekardex): void
    {
        //
    }
}
