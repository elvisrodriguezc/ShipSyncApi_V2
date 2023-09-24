<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Tariff;
use App\Http\Requests\V1\StoreTariffRequest;
use App\Http\Requests\V1\UpdateTariffRequest;
use App\Http\Resources\V1\TariffResource;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;

class TariffController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $data = QueryBuilder::for(Tariff::class)
            ->allowedFilters(['text'])
            ->defaultSort('-created_at')
            ->allowedSorts(['text'])
            ->where('company_id', $user->company_id)
            ->get();

        return TariffResource::collection($data)
            ->additional([
                'msg' => 'Listado correcto',
                'title' => 'Tarifas',
                'Error' => 0,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTariffRequest $request)
    {
        $user = Auth::user();
        $tariffData = $request->validated();
        $tariffData['company_id'] = $user->company_id; // Add the company_id field with user company
        $data = Tariff::create($tariffData);
        return TariffResource::make($data)
            ->additional([
                'msg' => 'Registro Creado Correctamente',
                'title' => 'Tarifas',
                'Error' => 0,
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tariff $tariff)
    {
        return TariffResource::make($tariff);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTariffRequest $request, Tariff $tariff)
    {
        $tariff->update($request->validated());
        return TariffResource::make($tariff)
            ->additional([
                'msg' => 'Registro Actualizado Correctamente',
                'title' => 'Tarifas',
                'Error' => 0,
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tariff $tariff)
    {
        $tariff->delete();
        return TariffResource::make($tariff)
            ->additional([
                'msg' => 'Registro Eliminado',
                'title' => 'Tarifas',
                'Error' => 0,
            ]);
    }
}
