<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Tariffitem;
use App\Http\Requests\V1\StoreTariffitemRequest;
use App\Http\Requests\V1\UpdateTariffitemRequest;
use App\Http\Resources\V1\TariffitemResource;
use Illuminate\Http\Request;

class TariffitemController extends Controller
{
    public function index(Request $request)
    {
        if ($request->tariff) {
            $data = Tariffitem::where('tariff_id', $request->tariff)
                ->get();
        } else {
            return json_encode([
                "data" => [],
                "error" => "Ingrese una tarifa"
            ]);
        }
        return TariffitemResource::collection($data)
            ->additional([
                'msg' => 'Listado correcto',
                'title' => 'Items de Tarifa',
                'Error' => 0,
            ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTariffitemRequest $request)
    {
        $formData = $request->validated();
        $data = Tariffitem::create($formData);
        return TariffitemResource::make($data)
            ->additional([
                'msg' => 'Registro Creado Correctamente',
                'title' => 'Items de Tarifa',
                'Error' => 0,
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tariffitem $tariffitem)
    {
        return TariffitemResource::make($tariffitem);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTariffitemRequest $request, Tariffitem $tariffitem)
    {
        $tariffitem->update($request->validated());
        return TariffitemResource::make($tariffitem)
            ->additional([
                'msg' => 'Registro Actualizado Correctamente',
                'title' => 'Items de Tarifa',
                'Error' => 0,
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tariffitem $tariffitem)
    {
        $tariffitem->delete();
        return TariffitemResource::make($tariffitem)
            ->additional([
                'msg' => 'Registro Eliminado',
                'title' => 'Items de Tarifa',
                'Error' => 0,
            ]);
    }
}
