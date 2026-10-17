<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $data = Car::where('company_id', $user->company_id)
            ->with(['entity'])
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            'data' => $data,
            'meta' => [
                'message' => 'Listado de vehículos',
                'total' => $data->count(),
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'description' => 'nullable|string|max:100',
            'plate' => 'nullable|string|max:10',
            'color' => 'nullable|string|max:50',
            'model' => 'nullable|string|max:50',
            'year' => 'nullable|string|max:4',
            'chassis' => 'nullable|string|max:50',
            'tuc' => 'nullable|string|max:50',
            'entity_id' => 'nullable|exists:entities,id',
            'status' => 'nullable|integer',
        ]);

        $validated['company_id'] = $user->company_id;

        // If entity_id not provided, pick first entity of company or null if allowed
        if (empty($validated['entity_id'])) {
            $firstEntity = \App\Models\Entity::where('company_id', $user->company_id)->first();
            $validated['entity_id'] = $firstEntity ? $firstEntity->id : 1;
        }

        $car = Car::create($validated);
        $car->load('entity');

        return response()->json([
            'message' => 'Vehículo creado exitosamente',
            'data' => $car,
            'error' => 0,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = auth()->user();
        $car = Car::where('company_id', $user->company_id)->with(['entity'])->findOrFail($id);

        return response()->json([
            'data' => $car,
            'error' => 0
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = auth()->user();
        $car = Car::where('company_id', $user->company_id)->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'description' => 'nullable|string|max:100',
            'plate' => 'nullable|string|max:10',
            'color' => 'nullable|string|max:50',
            'model' => 'nullable|string|max:50',
            'year' => 'nullable|string|max:4',
            'chassis' => 'nullable|string|max:50',
            'tuc' => 'nullable|string|max:50',
            'entity_id' => 'nullable|exists:entities,id',
            'status' => 'nullable|integer',
        ]);

        $car->update($validated);
        $car->load('entity');

        return response()->json([
            'message' => 'Vehículo actualizado exitosamente',
            'data' => $car,
            'error' => 0,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = auth()->user();
        $car = Car::where('company_id', $user->company_id)->findOrFail($id);
        $car->delete();

        return response()->json([
            'message' => 'Vehículo eliminado exitosamente',
            'error' => 0,
        ]);
    }
}
