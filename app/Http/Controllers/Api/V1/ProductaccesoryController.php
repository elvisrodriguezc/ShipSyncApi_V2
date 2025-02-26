<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreProductaccesoryRequest;
use App\Http\Requests\V1\UpdateProductaccesoryRequest;
use App\Http\Resources\V1\ProductaccesoryResource;
use App\Models\Product;
use App\Models\Productaccesory;
use Illuminate\Http\Request;

class ProductaccesoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Productaccesory::all();
        return ProductaccesoryResource::collection($data)
            ->additional([
                'msg' => 'Listado correcto',
                'title' => 'Accesorio',
                'Error' => 0,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductaccesoryRequest $request)
    {
        $formData = $request->validated();
        $data = new Productaccesory($formData);
        $data->save();
        return (new ProductaccesoryResource($data))
            ->additional([
                'msg' => 'Guardado correctamente',
                'title' => 'Accesorio',
                'Error' => 0,
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Productaccesory $productaccesory)
    {
        return (new ProductaccesoryResource($productaccesory))
            ->additional([
                'msg' => 'Consulta correcta',
                'title' => 'Accesorio',
                'Error' => 0,
            ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductaccesoryRequest $request, Productaccesory $productaccesory)
    {
        $formData = $request->validated();
        $productaccesory->update($formData);
        return (new ProductaccesoryResource($productaccesory))
            ->additional([
                'msg' => 'Actualizado correctamente',
                'title' => 'Accesorio',
                'Error' => 0,
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Productaccesory $productaccesory)
    {
        $productaccesory->delete();
        return response()->json([
            'msg' => 'Eliminado correctamente',
            'title' => 'Componente ',
            'Error' => 0,
        ]);
    }
}
