<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreBrandRequest;
use App\Http\Requests\V1\UpdateBrandRequest;
use App\Http\Resources\V1\BrandResource;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $data = QueryBuilder::for(Brand::class)
            ->allowedFilters(['name'])
            ->defaultSort('name')
            ->allowedSorts(['name'])
            ->where('company_id', $user->company_id)
            ->get();
        return BrandResource::collection($data)
            ->additional([
                'msg' => 'Listado correcto',
                'title' => 'Marcas',
                'Error' => 0,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBrandRequest $request)
    {
        $user = Auth::user();
        $formData = $request->validated();
        $formData['company_id'] = $user->company_id; // Add the company_id field with user company

        $brand = Brand::create($formData);
        return BrandResource::make($brand)
            ->additional([
                'msg' => 'Registro Creado Correctamente',
                'title' => 'Marcas',
                'Error' => 0,
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        return BrandResource::make($brand);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBrandRequest $request, Brand $brand)
    {
        $brand->update($request->validated());
        return BrandResource::make($brand)
            ->additional([
                'msg' => 'Registro Actualizado Correctamente',
                'title' => 'Marcas',
                'Error' => 0,
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        $brand->delete();
        return BrandResource::make($brand)
            ->additional([
                'msg' => 'Registro Eliminado',
                'title' => 'Marcas',
                'Error' => 0,
            ]);
    }
}
