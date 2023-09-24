<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Http\Requests\V1\StoreOrderRequest;
use App\Http\Requests\V1\UpdateOrderRequest;
use App\Http\Resources\V1\OrderResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        if ($request->mode === "cashier") {
            $data = QueryBuilder::for(Order::class)
                ->allowedFilters(['id'])
                ->defaultSort('-created_at')
                ->allowedSorts(['id'])
                ->where('company_id', $user->company_id)
                ->wherenot('status', 2)
                ->get();
        } else {
            $data = QueryBuilder::for(Order::class)
                ->allowedFilters(['id'])
                ->defaultSort('-created_at')
                ->allowedSorts(['id'])
                ->where('company_id', $user->company_id)
                ->get();
        }

        return OrderResource::collection($data)
            ->additional([
                'msg' => 'Listado correcto',
                'title' => 'Órdenes de Venta',
                'Error' => 0,
            ]);
    }

    public function store(StoreOrderRequest $request)
    {
        $user = Auth::user();
        $formData = $request->validated();
        $formData['company_id'] = $user->company_id; // Add the company_id
        $formData['user_id'] = $user->id; // Add the user_id
        $data = Order::create($formData);
        return OrderResource::make($data)
            ->additional([
                'msg' => 'Registro Creado Correctamente',
                'title' => 'Órdenes de Venta',
                'Error' => 0,
            ]);
    }

    public function show(Order $order)
    {
        return OrderResource::make($order);
    }

    public function update(UpdateOrderRequest $request, Order $order)
    {
        $order->update($request->validated());
        return OrderResource::make($order)
            ->additional([
                'msg' => 'Registro Actualizado Correctamente',
                'title' => 'Órdenes de Venta',
                'Error' => 0,
            ]);
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return OrderResource::make($order)
            ->additional([
                'msg' => 'Registro Eliminado',
                'title' => 'Órdenes de Venta',
                'Error' => 0,
            ]);
    }
}
