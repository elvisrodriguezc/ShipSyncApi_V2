<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $data = Position::where('company_id', $user->company_id)
            ->where('status', 1)
            ->get();

        return response()->json([
            'data' => $data,
            'meta' => [
                'total' => $data->count(),
            ]
        ]);
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $validated = $request->validate([
            'name' => 'required|string|max:100',
        ]);
        $validated['company_id'] = $user->company_id;

        $position = Position::create($validated);

        return response()->json([
            'message' => 'Puesto creado exitosamente',
            'data' => $position,
            'error' => 0
        ], 201);
    }
}
