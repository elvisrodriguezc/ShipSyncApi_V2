<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Office;
use App\Http\Requests\V1\StoreOrderRequest;
use App\Http\Requests\V1\UpdateOrderRequest;
use App\Http\Resources\V1\OrderResource;
use App\Models\Orderitem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $officeId = Office::where('company_id', $user->company_id)->pluck('id')->first();
        $query = Order::where('office_id', $officeId)
            ->get();

        return OrderResource::collection($query)
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
        $formData['cashier_id'] = 1; // Add the user_id
        $formData['number'] = $request->number; // Add the user_id
        $total = 0;
        foreach ($request->items as $item) {
            $total += $item['quantity'] * $item['price'];
        }
        $formData['total'] = $total;
        $order = Order::create($formData);

        foreach ($request->items as $item) {
            // dd($item);
            $orderitem = Orderitem::create([
                'order_id' => $order->id,
                'product_serie_id' => 1,
                'splitfrom' => 0,
                'tariffitem_id' => $item['tariffitem_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'discount' => 0,
                'discount_percent' => 0,
                'description' => "",
                'status_comment' => "",
                'status' => 1,
            ]);
        }
        return OrderResource::make($order)
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
