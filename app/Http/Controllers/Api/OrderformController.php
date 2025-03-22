<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderformRequest;
use App\Http\Requests\UpdateOrderformRequest;
use App\Http\Resources\OrderformResource;
use App\Models\Orderform;
use Illuminate\Http\Request;

class OrderformController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        if (strpos($user->role->name, 'admin') !== false) {
            $data = Orderform::whereBetween('created_at', [now()->subDays(7), now()])
                ->get();
        } else {
            $data = Orderform::where('warehouse_id', $user->warehouse_id)
                ->whereBetween('created_at', [now()->subDays(1), now()])
                ->get();
        }

        return OrderformResource::collection($data)
            ->additional([
                'meta' => [
                    'message' => 'Listado de ordenes de pedido',
                    'error' => 0,
                    'total' => $data->count(),
                ]
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(StoreOrderformRequest $request)
    {
        $user = auth()->user();
        $request->validated();
        $orderform = new Orderform($request->all());
        $orderform->company_id = $user->company_id;
        $orderform->user_id = $user->id;
        $orderform->warehouse_id = $user->warehouse_id;
        $orderform->headquarter_id = $user->headquarter_id;
        $orderform->status = 1;
        $orderform->save();

        return OrderformResource::make($orderform)->additional([
            'message' => 'Orden de pedido creada correctamente',
            'error' => 0,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Orderform $orderform)
    {
        return OrderformResource::make($orderform);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderformRequest $request, Orderform $orderform)
    {
        $request->validated();
        $request->merge(['finished_at' => now()]);
        $orderform->update($request->all());

        return OrderformResource::make($orderform)->additional([
            'message' => 'Orden de pedido actualizada correctamente',
            'error' => 0,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Orderform $orderform)
    {
        $orderform->delete();

        return OrderformResource::make($orderform)->additional([
            'message' => 'Orden de pedido eliminada correctamente',
            'error' => 0,
        ]);
    }
}
