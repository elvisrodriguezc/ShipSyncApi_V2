<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $data = Product::where('company_id', $user->company_id)
            ->orderBy('name', 'asc')
            ->get();
        return ProductResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $user = auth()->user();
        $request->validated();
        $request->merge([
            'company_id' => $user->company_id,
        ]);
        try {
            $data = Product::create($request->all());
            return ProductResource::make($data);
        } catch (QueryException $e) {
            if ($e->getCode() === '23000') { // SQLSTATE code for integrity constraint violation
                return response()->json([
                    'error' => 'Se intentó Duplicar el Nombre del Producto.',
                ], 409);
            }
            throw $e;
        }
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
        $request->validated();
        $product->update($request->all());
        return ProductResource::make($product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return ProductResource::make($product)->additional([
            'message' => 'Product deleted successfully',
        ]);
    }
}
