<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Tariff;
use App\Http\Requests\V1\StoreTariffRequest;
use App\Http\Requests\V1\UpdateTariffRequest;
use App\Http\Resources\V1\TariffResource;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class TariffController extends Controller
{
    public function index(Request $request)
    {
        if ($request->warehouse) {
            $data = QueryBuilder::for(Tariff::class)
                ->allowedFilters(['text'])
                ->defaultSort('created_at')
                ->allowedSorts(['text'])
                ->where('warehouse_id', $request->warehouse)
                ->get();
        } else {

            return $data = response()->json([
                "data" => "Ups, Houston, I don't know what do you need. Please espedify the Wharehouse parameter and a value",
                "message" => "Error",
                "error" => 1
            ], 400);
        }


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
        // $user = Auth::user();
        $tariffData = $request->validated();
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
