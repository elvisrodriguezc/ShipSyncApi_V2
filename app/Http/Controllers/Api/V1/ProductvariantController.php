<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreProductvariantRequest;
use App\Http\Requests\V1\UpdateProductvariantRequest;
use App\Http\Resources\V1\ProductvariantResource;
use App\Models\Productvariant;
use App\Models\Productvariantdetail;
use Illuminate\Http\Request;

class ProductvariantController extends Controller
{
    public function index()
    {
        $query = Productvariant::get();

        return ProductvariantResource::collection($query)
            ->additional([
                'msg' => 'Listado correcto',
                'title' => 'Variantes del Producto',
                'Error' => 0,
            ]);
    }

    public function store(StoreProductvariantRequest $request)
    {
        $formData = $request->validated();
        $productvariant = Productvariant::create($formData);
        return ProductvariantResource::make($productvariant)
            ->additional([
                'msg' => 'Registro Creado Correctamente',
                'title' => 'Variantes del Producto',
                'Error' => 0,
            ]);
    }

    public function show(Productvariant $productvariant)
    {
        return ProductvariantResource::make($productvariant)
            ->additional([
                'msg' => 'Registro Actual',
                'title' => 'Variantes del Producto',
                'Error' => 0,
            ]);
    }

    public function update(UpdateProductvariantRequest $request, Productvariant $productvariant)
    {
        $productvariant->update($request->validated());
        return ProductvariantResource::make($productvariant)
            ->additional([
                'msg' => 'Registro Actualizado Correctamente',
                'title' => 'Variantes del Producto',
                'Error' => 0,
            ]);
    }

    public function destroy(Productvariant $productvariant)
    {
        $productvariant->delete();
        return ProductvariantResource::make($productvariant)
            ->additional([
                'msg' => 'Registro Eliminado',
                'title' => 'Variantes del Producto',
                'Error' => 0,
            ]);
    }
}
