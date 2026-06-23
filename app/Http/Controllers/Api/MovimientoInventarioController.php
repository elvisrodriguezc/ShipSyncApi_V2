<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMovimientoInventarioRequest;
use App\Http\Requests\UpdateMovimientoInventarioRequest;
use App\Http\Resources\MovimientoInventarioResource;
use App\Models\MovimientoInventario;

class MovimientoInventarioController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $data = MovimientoInventario::where('company_id', $user->company_id)
            ->with('batch', 'producto', 'usuario', 'warehouse')
            ->orderBy('fecha_movimiento', 'desc')
            ->get();
        return MovimientoInventarioResource::collection($data);
    }

    public function store(StoreMovimientoInventarioRequest $request)
    {
        $user = auth()->user();
        $data = $request->validated();
        $data['company_id'] = $user->company_id;
        $movimiento = MovimientoInventario::create($data);
        $movimiento->load('batch', 'producto', 'usuario', 'warehouse');
        return MovimientoInventarioResource::make($movimiento);
    }

    public function show($id)
    {
        $movimiento = MovimientoInventario::where('company_id', auth()->user()->company_id)
            ->with('batch', 'producto', 'usuario', 'warehouse')
            ->findOrFail($id);
        return MovimientoInventarioResource::make($movimiento);
    }

    public function update(UpdateMovimientoInventarioRequest $request, $id)
    {
        $user = auth()->user();
        $data = $request->validated();
        $movimiento = MovimientoInventario::where('company_id', $user->company_id)
            ->findOrFail($id);
        $movimiento->update($data);
        $movimiento->load('batch', 'producto', 'usuario', 'warehouse');
        return MovimientoInventarioResource::make($movimiento);
    }

    public function destroy($id)
    {
        $movimiento = MovimientoInventario::where('company_id', auth()->user()->company_id)
            ->findOrFail($id);
        $movimiento->delete();
        return response()->json(['message' => 'Movimiento eliminado correctamente']);
    }
}
