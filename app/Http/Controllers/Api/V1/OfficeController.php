<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Office;
use App\Http\Requests\V1\StoreOfficeRequest;
use App\Http\Requests\V1\UpdateOfficeRequest;
use App\Http\Resources\V1\OfficeResource;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;

class OfficeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $data = QueryBuilder::for(Office::class)
            ->allowedFilters(['name'])
            ->defaultSort('-created_at')
            ->allowedSorts(['name'])
            ->where('company_id', $user->company_id)
            ->get();

        return OfficeResource::collection($data)
            ->additional([
                'msg' => 'Listado correcto',
                'title' => 'Oficinas Sucursales',
                'Error' => 0,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOfficeRequest $request)
    {
        $user = Auth::user();
        $categoryData = $request->validated();
        $categoryData['company_id'] = $user->company_id; // Add the company_id field with user company
        $data = Office::create($categoryData);
        return OfficeResource::make($data)
            ->additional([
                'msg' => 'Registro Creado Correctamente',
                'title' => 'Oficinas Sucursales',
                'Error' => 0,
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Office $office)
    {
        return OfficeResource::make($office);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOfficeRequest $request, Office $office)
    {
        $office->update($request->validated());
        return OfficeResource::make($office)
            ->additional([
                'msg' => 'Registro Actualizado Correctamente',
                'title' => 'Office',
                'Error' => 0,
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Office $office)
    {
        $office->delete();
        return OfficeResource::make($office)
            ->additional([
                'msg' => 'Registro Eliminado',
                'title' => 'Oficinas Sucursales',
                'Error' => 0,
            ]);
    }
}
