<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Warehouse;
use App\Http\Requests\V1\StoreWarehouseRequest;
use App\Http\Requests\V1\UpdateWarehouseRequest;
use App\Http\Resources\V1\WarehouseResource;
use App\Models\Office;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    public function index(Request $request)
    {
        // dd($request->office);
        if ($request->office) {
            $data = Warehouse::where('office_id', $request->office)
                ->get();
        } else if ($request->company) {
            // Obtener todas las oficinas que pertenecen a la compañía especificada
            $offices = Office::where('company_id', $request->company)->pluck('id');

            // Obtener todos los almacenes que pertenecen a las oficinas obtenidas
            $data = Warehouse::whereIn('office_id', $offices)->get();
        } else {
            return $data = response()->json([
                "data" => "Ups, Houston, I don't know what do you need. Please espedify the Company or Office parameter and a value",
                "message" => "Error",
                "error" => 1
            ], 400);
        }
        return WarehouseResource::collection($data)
            ->additional([
                'msg' => 'Listado correcto',
                'title' => 'Almacenes',
                'Error' => 0,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWarehouseRequest $request)
    {
        $warehouseData = $request->validated();
        $data = Warehouse::create($warehouseData);
        return WarehouseResource::make($data)
            ->additional([
                'msg' => 'Registro Creado Correctamente',
                'title' => 'Almacenes',
                'Error' => 0,
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Warehouse $warehouse)
    {
        return WarehouseResource::make($warehouse);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWarehouseRequest $request, Warehouse $warehouse)
    {
        $warehouse->update($request->validated());
        return WarehouseResource::make($warehouse)
            ->additional([
                'msg' => 'Registro Actualizado Correctamente',
                'title' => 'Almacenes',
                'Error' => 0,
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Warehouse $warehouse)
    {
        $warehouse->delete();
        return WarehouseResource::make($warehouse)
            ->additional([
                'msg' => 'Registro Eliminado',
                'title' => 'Almacenes',
                'Error' => 0,
            ]);
    }
}
