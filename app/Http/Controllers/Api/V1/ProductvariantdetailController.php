<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreProductvariantdetailRequest;
use App\Http\Requests\V1\UpdateProductvariantdetailRequest;
use App\Http\Resources\V1\ProductvariantdetailResource;
use App\Models\Productvariantdetail;
use Illuminate\Http\Request;

class ProductvariantdetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Productvariantdetail::get();
        return ProductvariantdetailResource::collection($query)
            ->additional([
                'msg' => 'Listado correcto',
                'title' => 'Detalle de Variantes de Producto',
                'Error' => 0,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductvariantdetailRequest $request)
    {
        $formData = $request->validated();
        $productvariantdetail = Productvariantdetail::create($formData);
        return ProductvariantdetailResource::make($productvariantdetail)
            ->additional([
                'msg' => 'Registro Creado Correctamente',
                'title' => 'Detalle de Variantes de Producto',
                'Error' => 0,
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Productvariantdetail $productvariantdetail)
    {
        return ProductvariantdetailResource::make($productvariantdetail)
            ->additional([
                'msg' => 'Registro Actual',
                'title' => 'Detalle de Variantes de Producto',
                'Error' => 0,
            ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductvariantdetailRequest $request, Productvariantdetail $productvariantdetail)
    {
        $productvariantdetail->update($request->validated());
        return ProductvariantdetailResource::make($productvariantdetail)
            ->additional([
                'msg' => 'Registro Actualizado Correctamente',
                'title' => 'Detalle de Variantes de Producto',
                'Error' => 0,
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Productvariantdetail $productvariantdetail)
    {
        $productvariantdetail->delete();
        return ProductvariantdetailResource::make($productvariantdetail)
            ->additional([
                'msg' => 'Registro Eliminado',
                'title' => 'Detalle de Variantes de Producto',
                'Error' => 0,
            ]);
    }
}
