<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreProductbomRequest;
use App\Http\Requests\V1\UpdateProductbomRequest;
use App\Http\Resources\V1\ProductbomResource;
use App\Models\Productbom;
use Illuminate\Http\Request;

class ProductbomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Productbom::all();
        return ProductbomResource::collection($data)
            ->additional([
                'msg' => 'Listado correcto',
                'title' => 'Producto BOM',
                'Error' => 0,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductbomRequest $request)
    {
        $formData = $request->validated();
        $data = new Productbom($formData);
        $data->save();
        return ProductbomResource::make($data)
            ->additional([
                'msg' => 'Registro creado',
                'title' => 'Producto BOM',
                'Error' => 0,
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Productbom $productbom)
    {
        return ProductbomResource::make($productbom)
            ->additional([
                'msg' => 'Consulta correcta',
                'title' => 'Producto BOM',
                'Error' => 0,
            ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductbomRequest $request, Productbom $productbom)
    {
        $formData = $request->validated();
        $productbom->update($formData);
        return ProductbomResource::make($productbom)
            ->additional([
                'msg' => 'Registro actualizado',
                'title' => 'Producto BOM',
                'Error' => 0,
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Productbom $productbom)
    {
        $productbom->delete();
        return ProductbomResource::make($productbom)
            ->additional([
                'msg' => 'Registro eliminado',
                'title' => 'Producto BOM',
                'Error' => 0,
            ]);
    }
}
