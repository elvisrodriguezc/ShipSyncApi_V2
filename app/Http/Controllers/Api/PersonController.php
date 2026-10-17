<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Person;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $data = Person::where('company_id', $user->company_id)
            ->with(['position', 'idCardType'])
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            'data' => $data,
            'meta' => [
                'message' => 'Listado de personal',
                'total' => $data->count(),
            ]
        ]);
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        // Support both puesto_id/position_id and idcardtype_id/id_card_type_id
        if ($request->has('puesto_id') && !$request->has('position_id')) {
            $request->merge(['position_id' => $request->input('puesto_id')]);
        }
        if ($request->has('idcardtype_id') && !$request->has('id_card_type_id')) {
            $request->merge(['id_card_type_id' => $request->input('idcardtype_id')]);
        }

        $validated = $request->validate([
            'position_id' => 'nullable|exists:positions,id',
            'id_card_type_id' => 'nullable|exists:id_card_types,id',
            'doc_number' => 'nullable|string|max:30',
            'names' => 'required|string|max:100',
            'last_name' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:30',
            'address' => 'nullable|string|max:255',
            'status' => 'nullable|integer',
        ]);

        $validated['company_id'] = $user->company_id;

        $person = Person::create($validated);
        $person->load(['position', 'idCardType']);

        return response()->json([
            'message' => 'Personal creado exitosamente',
            'data' => $person,
            'error' => 0,
        ], 201);
    }

    public function show($id)
    {
        $user = auth()->user();
        $person = Person::where('company_id', $user->company_id)
            ->with(['position', 'idCardType'])
            ->findOrFail($id);

        return response()->json([
            'data' => $person,
            'error' => 0,
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = auth()->user();
        $person = Person::where('company_id', $user->company_id)->findOrFail($id);

        if ($request->has('puesto_id') && !$request->has('position_id')) {
            $request->merge(['position_id' => $request->input('puesto_id')]);
        }
        if ($request->has('idcardtype_id') && !$request->has('id_card_type_id')) {
            $request->merge(['id_card_type_id' => $request->input('idcardtype_id')]);
        }

        $validated = $request->validate([
            'position_id' => 'nullable|exists:positions,id',
            'id_card_type_id' => 'nullable|exists:id_card_types,id',
            'doc_number' => 'nullable|string|max:30',
            'names' => 'required|string|max:100',
            'last_name' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:30',
            'address' => 'nullable|string|max:255',
            'status' => 'nullable|integer',
        ]);

        $person->update($validated);
        $person->load(['position', 'idCardType']);

        return response()->json([
            'message' => 'Personal actualizado exitosamente',
            'data' => $person,
            'error' => 0,
        ]);
    }

    public function destroy($id)
    {
        $user = auth()->user();
        $person = Person::where('company_id', $user->company_id)->findOrFail($id);
        $person->delete();

        return response()->json([
            'message' => 'Personal eliminado exitosamente',
            'error' => 0,
        ]);
    }
}
