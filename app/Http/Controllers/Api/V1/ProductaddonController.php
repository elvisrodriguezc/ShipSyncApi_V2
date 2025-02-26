<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreProductaddonRequest;
use App\Http\Requests\V1\UpdateProductaddonRequest;
use App\Http\Resources\V1\ProductaddonResource;
use App\Models\Productaddon;
use Illuminate\Http\Request;

class ProductaddonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Productaddon::all();
        return ProductaddonResource::collection($data)
            ->additional([
                'msg' => 'Listado correcto',
                'title' => 'Addon',
                'Error' => 0,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductaddonRequest $request)
    {
        $formdata = $request->validated();
        $data = new Productaddon($formdata);
        $data->save();
        return (new ProductaddonResource($data))
            ->additional([
                'msg' => 'Guardado correctamente',
                'title' => 'Addon',
                'Error' => 0,
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Productaddon $productaddon)
    {
        return (new ProductaddonResource($productaddon))
            ->additional([
                'msg' => 'Consulta correcta',
                'title' => 'Addon',
                'Error' => 0,
            ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductaddonRequest $request, Productaddon $productaddon)
    {
        $formdata = $request->validated();
        $productaddon->update($formdata);
        return (new ProductaddonResource($productaddon))
            ->additional([
                'msg' => 'Actualizado correctamente',
                'title' => 'Addon',
                'Error' => 0,
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Productaddon $productaddon)
    {
        $productaddon->delete();
        return response()->json([
            'msg' => 'Eliminado correctamente',
            'title' => 'Addon',
            'Error' => 0,
        ]);
    }
}
