<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Requests\V1\StoreProductRequest;
use App\Http\Requests\V1\UpdateProductRequest;
use App\Http\Resources\V1\ProductResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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
        $formData['company_id'] = $user->company_id; // Agregar el campo company_id con la compañía del usuario
        // $data = Product::create($formData);
        $data = new Product($formData);
        $path = $request->image->store('products', 'images');
        $data->image = $path; // Asignar la ruta de la imagen al campo image_url del producto
        $data->save(); // Guardar los cambios en la base de datos
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
        return DB::transaction(function () use ($request, $product) {
            $formData = $request->validated();

            if ($request->hasFile('image')) {
                $previousImage = $product->image;
                if ($previousImage) {
                    Storage::disk('images')->delete($previousImage);
                }
                $path = $request->file('image')->store('products', 'images');
                $formData['image'] = $path;
            }
            $product->update($formData);
            return ProductResource::make($product)->additional([
                'msg' => 'Registro Actualizado Correctamente',
                'title' => 'Producto',
                'Error' => 0,
            ]);
        }, 5);
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
