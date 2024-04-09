<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\VehicleResource;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $data = QueryBuilder::for(Vehicle::class)
            ->get();

        return VehicleResource::collection($data)
            ->additional([
                'msg' => 'Listado correcto',
                'title' => 'Entidades1',
                'Error' => 0,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $formData = $request->validated();
        $formData['company_id'] = $user->company_id; // Add the company_id field with user company
        $data = Vehicle::create($formData);
        return VehicleResource::make($data)
            ->additional([
                'msg' => 'Registro Creado Correctamente',
                'title' => 'Entidades',
                'Error' => 0,
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Vehicle $vehicle)
    {
        return VehicleResource::make($tipo);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vehicle $vehicle)
    {
        //
    }
}
