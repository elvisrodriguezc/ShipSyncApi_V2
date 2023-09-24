<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Requests\V1\StoreProductRequest;
use App\Http\Requests\V1\UpdateProductRequest;
use App\Http\Resources\V1\ProductResource;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $data = QueryBuilder::for(Product::class)
            ->allowedFilters(['name'])
            ->defaultSort('name')
            ->allowedSorts(['name', 'status'])
            ->where('company_id', $user->company_id)
            ->get();
        return ProductResource::collection($data)
            ->additional([
                'msg' => 'Listado correcto',
                'title' => 'Producto',
                'Error' => 0,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $user = Auth::user();
        $formData = $request->validated();
        $formData['company_id'] = $user->company_id; // Add the company_id field with user company
        $data = Product::create($formData);
        return ProductResource::make($data)
            ->additional([
                'msg' => 'Registro Creado Correctamente',
                'title' => 'Producto',
                'Error' => 0,
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return ProductResource::make($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->validated());
        return ProductResource::make($product)
            ->additional([
                'msg' => 'Registro Actualizado Correctamente',
                'title' => 'Producto',
                'Error' => 0,
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return ProductResource::make($product)
            ->additional([
                'msg' => 'Registro Eliminado',
                'title' => 'Producto',
                'Error' => 0,
            ]);
    }
}
