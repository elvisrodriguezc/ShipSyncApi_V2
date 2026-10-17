<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OrderformDelivery;
use Illuminate\Http\Request;

class OrderformDeliveryController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $data = OrderformDelivery::where('company_id', $user->company_id)
            ->with([
                'orderform.contact',
                'car',
                'person.position',
                'person.idCardType'
            ])
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            'data' => $data,
            'meta' => [
                'message' => 'Listado de entregas / reparto',
                'total' => $data->count(),
            ]
        ]);
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'orderform_id' => 'required|exists:orderforms,id',
            'car_id' => 'nullable|exists:cars,id',
            'person_id' => 'nullable|exists:persons,id',
            'trayquantity' => 'required|integer|min:0',
            'tray_returned_quantity' => 'nullable|integer|min:0',
            'returned' => 'nullable|date',
            'status' => 'nullable|integer',
        ]);

        $validated['company_id'] = $user->company_id;
        if (!isset($validated['tray_returned_quantity'])) {
            $validated['tray_returned_quantity'] = 0;
        }

        $delivery = OrderformDelivery::create($validated);
        $delivery->load([
            'orderform.contact',
            'car',
            'person.position',
            'person.idCardType'
        ]);

        return response()->json([
            'message' => 'Entrega registrada exitosamente',
            'data' => $delivery,
            'error' => 0,
        ], 201);
    }

    public function show($id)
    {
        $user = auth()->user();
        $delivery = OrderformDelivery::where('company_id', $user->company_id)
            ->with([
                'orderform.contact',
                'car',
                'person.position',
                'person.idCardType'
            ])
            ->findOrFail($id);

        return response()->json([
            'data' => $delivery,
            'error' => 0,
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = auth()->user();
        $delivery = OrderformDelivery::where('company_id', $user->company_id)->findOrFail($id);

        $validated = $request->validate([
            'orderform_id' => 'sometimes|required|exists:orderforms,id',
            'car_id' => 'nullable|exists:cars,id',
            'person_id' => 'nullable|exists:persons,id',
            'trayquantity' => 'sometimes|required|integer|min:0',
            'tray_returned_quantity' => 'nullable|integer|min:0',
            'returned' => 'nullable|date',
            'status' => 'nullable|integer',
        ]);

        $delivery->update($validated);
        $delivery->load([
            'orderform.contact',
            'car',
            'person.position',
            'person.idCardType'
        ]);

        return response()->json([
            'message' => 'Registro de entrega actualizado exitosamente',
            'data' => $delivery,
            'error' => 0,
        ]);
    }

    public function destroy($id)
    {
        $user = auth()->user();
        $delivery = OrderformDelivery::where('company_id', $user->company_id)->findOrFail($id);
        $delivery->delete();

        return response()->json([
            'message' => 'Registro de entrega eliminado exitosamente',
            'error' => 0,
        ]);
    }
}
