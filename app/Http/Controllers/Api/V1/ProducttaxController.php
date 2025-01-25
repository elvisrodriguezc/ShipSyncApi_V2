<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreProducttaxRequest;
use App\Http\Resources\V1\ProducttaxResource;
use App\Models\Producttax;
use Illuminate\Http\Request;

class ProducttaxController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Producttax::get();
        return ProducttaxResource::collection($query)
            ->additional([
                'msg' => 'Listado correcto',
                'title' => 'Impuestos de productos',
                'Error' => 0,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProducttaxRequest $request)
    {
        $formData = $request->validated();
        $producttax = Producttax::create($formData);
        return ProducttaxResource::make($producttax)
            ->additional([
                'msg' => 'Registro Creado Correctamente',
                'title' => 'Impuesto nuevo',
                'Error' => 0,
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Producttax $producttax)
    {
        return ProducttaxResource::make($producttax);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Producttax $producttax)
    {
        $formData = $request->all();
        $producttax->update($formData);
        return ProducttaxResource::make($producttax)
            ->additional([
                'msg' => 'Registro Actualizado Correctamente',
                'title' => 'Impuesto actualizado',
                'Error' => 0,
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producttax $producttax)
    {
        $producttax->delete();
        return response()->json([
            'msg' => 'Registro Eliminado Correctamente',
            'title' => 'Impuesto eliminado',
            'Error' => 0,
        ]);
    }
}
