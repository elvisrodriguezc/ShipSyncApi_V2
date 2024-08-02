<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Tariffitem;
use App\Http\Requests\V1\StoreProductRequest;
use App\Http\Requests\V1\UpdateProductRequest;
use App\Http\Resources\V1\ProductResource;
use App\Models\Productvariant;
use App\Models\Productvariantdetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;
// use Symfony\Component\Mime\Part\Multipart\FormDataPart;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $data = Product::where('company_id', $user->company_id)
            ->withSum(['warehousestocks as total_stock' => function ($query) use ($user) {
                $query->where('company_id', $user->company_id);
            }], 'stock')
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
        $formData['company_id'] = $user->company_id; // Agregar el campo company_id con el valor de la Empresa del usuario
        $data = new Product($formData);

        if ($request->hasFile('image')) {
            $path = $request->image->store('products', 'images');
            $data->image = $path; // Asignar la ruta de la imagen al campo image_url del producto

            // create new image instance
            $image = ImageManager::imagick()->read(storage_path('app/public/images/' . $path));

            // resize only image height to 400 pixels
            $image->scale(height: 400);
            $image->save(storage_path('app/public/images/' . $path));
        } else {
            $data->image = ""; // Asignar la ruta de la imagen al campo image_url del producto
        }

        $data->save(); // Guardar los cambios en la base de datos

        foreach ($request->tariffs as $tariffId) {
            TariffItem::create([
                'tariff_id' => $tariffId,
                'warehouse_id' => 1, // Valor fijo para el campo warehouse
                'product_id' => $data->id, // Asignar el ID del producto
            ]);
        }

        if (!empty($request->variants)) {
            foreach ($request->variants as $variant) {
                $productVariant = Productvariant::create([
                    'product_id' => $data->id, // Asignar el ID del producto
                    'sku' => $variant['sku'],
                    'price' => $variant['price'],
                    'image' => $variant['image'],
                    'warehouse_id' => 1, // Valor fijo para el campo warehouse
                ]);
                foreach ($variant['variantdetails'] as $Item) {
                    Productvariantdetail::create([
                        'productvariant_id' => $productVariant->id,
                        'typevalue_id' => $Item['id'], // Asignar el ID del producto
                    ]);
                }
            }
        }

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
        // return DB::transaction(function () use ($request, $product) {
        $formData = $request->validated();

        // if ($request->hasFile('image')) {

        //     // Redimensionar la imagen
        //         $constraint->aspectRatio();
        //     });
        //     $image->save(storage_path('app/images/' . $path));
        // }
        if ($request->hasFile('image')) {
            $previousImage = $product->image;
            if ($previousImage) {
                Storage::disk('images')->delete($previousImage);
            }
            $path = $request->file('image')->store('products', 'images');
            $formData['image'] = $path;

            // $path = $request->image->store('products', 'images');
            // $data->image = $path; // Asignar la ruta de la imagen al campo image_url del producto

            // create new image instance
            $image = ImageManager::imagick()->read(storage_path('app/public/images/' . $path));
            // resize only image height to 400 pixels
            $image->scale(height: 400);
            $image->save(storage_path('app/public/images/' . $path));
        } else

            $product->update($formData);
        return ProductResource::make($product)
            ->additional([
                'msg' => 'Registro Actualizado Correctamente',
                'title' => 'Producto',
                'Error' => 0,
            ]);
        // }, 2);
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
