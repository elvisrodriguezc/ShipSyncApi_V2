<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Http\Resources\V1\PurchaseResource;
use App\Http\Requests\V1\StorePurchaseRequest;
use App\Http\Requests\V1\UpdatePurchaseRequest;
use App\Models\Purchaseitem;
use App\Models\Warehouse;
use App\Models\Warehousekardex;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        if (in_array($user->role, ['admin', 'sadmin'])) {
            $query = Purchase::where('company_id', $user->company_id)
                ->where('user_id', $user->id)
                ->get();
        } else {
            $query = Purchase::where('company_id', $user->company_id)
                ->get();
        }

        return PurchaseResource::collection($query)
            ->additional([
                'msg' => 'Listado correcto',
                'title' => 'Categorias',
                'Error' => 0,
            ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePurchaseRequest $request)
    {
        $formData = $request->validated();
        $purchase = Purchase::create($formData);
        foreach ($request->items as $item) {
            $purchaseItem = Purchaseitem::create([
                'purchase_id' => $purchase->id,
                'product_id' => $item["product"]['id'],
                'unity_id' => $item['product']['unity_id'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'discount' => $item['discount'],
                'discount_percent' => $item['discount_percent'],
            ]);
            $stockValue = Warehousekardex::where('warehouse_id', $purchase['warehouse_id'])
                ->where('product_id', $item['product']['id'])
                ->latest('created_at')
                ->pluck('stock')
                ->first(); // Obtiene el valor del campo 'stock' del primer registro

            if ($stockValue !== null) {
                $prevstock = $stockValue;
            } else {
                $prevstock = 0;
            }
            $roundedPrice = round($item['price'], 4); // Limitar a 4 dígitos decimales

            Warehousekardex::create([
                'warehouse_id' => $purchase['warehouse_id'],
                'product_id' => $item["product"]["id"],
                'unity_id' => $item['product']['unity_id'],
                'in' => $item['quantity'],
                'out' => 0,
                'price' => $roundedPrice,
                'purchaseitem_id' => $purchaseItem->id,
                'prevstock' => $prevstock,
                'stock' => round($prevstock + ($item['quantity'] * $item["unity"]["valor"] / $item['product']['unity_valor']), 2),
            ]);
        }
        return PurchaseResource::make($purchase)
            ->additional([
                'msg' => 'Registro Creado Correctamente',
                'title' => 'Categorias',
                'Error' => 0,
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Purchase $purchase)
    {
        return PurchaseResource::make($purchase);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePurchaseRequest $request, Purchase $purchase)
    {
        $purchase->update($request->validated());
        return PurchaseResource::make($purchase)
            ->additional([
                'msg' => 'Registro Actualizado Correctamente',
                'title' => 'Categorias',
                'Error' => 0,
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Purchase $purchase)
    {
        $purchase->delete();
        return PurchaseResource::make($purchase)
            ->additional([
                'msg' => 'Registro Eliminado',
                'title' => 'Categorias',
                'Error' => 0,
            ]);
    }
}
