<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Taxmode;
use App\Http\Requests\V1\StoreTaxmodeRequest;
use App\Http\Requests\V1\UpdateTaxmodeRequest;
use App\Http\Resources\V1\TaxmodeResource;
use Spatie\QueryBuilder\QueryBuilder;

class TaxmodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = QueryBuilder::for(Taxmode::class)
            ->allowedFilters(['text'])
            ->defaultSort('-created_at')
            ->allowedSorts(['text'])
            ->get();

        return TaxmodeResource::collection($data)
            ->additional([
                'msg' => 'Listado correcto',
                'title' => 'Categorias',
                'Error' => 0,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaxmodeRequest $request)
    {
        $formData = $request->validated();
        $data = Taxmode::create($formData);
        return TaxmodeResource::make($data)
            ->additional([
                'msg' => 'Registro Creado Correctamente',
                'title' => 'Categorias',
                'Error' => 0,
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Taxmode $taxmode)
    {
        return TaxmodeResource::make($taxmode);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaxmodeRequest $request, Taxmode $taxmode)
    {
        $taxmode->update($request->validated());
        return TaxmodeResource::make($taxmode)
            ->additional([
                'msg' => 'Registro Actualizado Correctamente',
                'title' => 'Afectación de Impuestos',
                'Error' => 0,
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Taxmode $taxmode)
    {
        $taxmode->delete();
        return TaxmodeResource::make($taxmode)
            ->additional([
                'msg' => 'Registro Eliminado',
                'title' => 'Categorias',
                'Error' => 0,
            ]);
    }
}
