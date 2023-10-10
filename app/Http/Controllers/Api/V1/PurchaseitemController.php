<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Purchaseitem;
use App\Http\Requests\V1\StorePurchaseitemRequest;
use App\Http\Requests\V1\UpdatePurchaseitemRequest;
use App\Http\Resources\V1\PurchaseitemResource;
use Spatie\QueryBuilder\QueryBuilder;

class PurchaseitemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = QueryBuilder::for(Purchaseitem::class)
            ->allowedFilters(['text'])
            ->defaultSort('-created_at')
            ->allowedSorts(['text'])
            ->get();

        return PurchaseitemResource::collection($data)
            ->additional([
                'msg' => 'Listado correcto',
                'title' => 'Categorias',
                'Error' => 0,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePurchaseitemRequest $request)
    {
        $formData = $request->validated();
        $data = Purchaseitem::create($formData);
        return PurchaseitemResource::make($data)
            ->additional([
                'msg' => 'Registro Creado Correctamente',
                'title' => 'Categorias',
                'Error' => 0,
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Purchaseitem $purchaseitem)
    {
        return PurchaseitemResource::make($purchaseitem);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePurchaseitemRequest $request, Purchaseitem $purchaseitem)
    {
        $purchaseitem->update($request->validated());
        return PurchaseitemResource::make($purchaseitem)
            ->additional([
                'msg' => 'Registro Actualizado Correctamente',
                'title' => 'Categorias',
                'Error' => 0,
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Purchaseitem $purchaseitem)
    {
        $purchaseitem->delete();
        return PurchaseitemResource::make($purchaseitem)
            ->additional([
                'msg' => 'Registro Eliminado',
                'title' => 'Categorias',
                'Error' => 0,
            ]);
    }
}
