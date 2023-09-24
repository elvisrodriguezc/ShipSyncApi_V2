<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Orderitem;
use App\Http\Requests\V1\StoreOrderitemRequest;
use App\Http\Requests\V1\UpdateOrderitemRequest;
use App\Http\Resources\V1\OrderitemCollection;
use App\Http\Resources\V1\OrderitemResource;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Http\Request;

class OrderitemController extends Controller
{
    public function index(Request $request)
    {
        // $data = QueryBuilder::for(Orderitem::class)
        //     ->allowedFilters(['text'])
        //     ->defaultSort('-created_at')
        //     ->allowedSorts(['text'])
        //     ->get();

        // return OrderitemResource::collection($data)
        //     ->additional([
        //         'msg' => 'Listado correcto',
        //         'title' => 'Items de Ordenes de Venta',
        //         'Error' => 0,
        //     ]);

        if ($request->order) {
            $Data = new OrderitemCollection(
                Orderitem::all()
                    ->where('order_id', $request->order)
                    ->SortByDesc('id')
                    ->values()
            );
        } else {
            $Data = response()->json([
                "data" => "Ups, Houston, I don't know what do you need. Please espedify the order parameter and a value",
                "message" => "Error",
                "error" => 1
            ], 200);
        }
        return $Data;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderitemRequest $request)
    {
        $formData = $request->validated();
        $data = Orderitem::create($formData);
        return OrderitemResource::make($data)
            ->additional([
                'msg' => 'Registro Creado Correctamente',
                'title' => 'Items de Ordenes de Venta',
                'Error' => 0,
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Orderitem $orderitem)
    {
        return OrderitemResource::make($orderitem);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderitemRequest $request, Orderitem $orderitem)
    {
        $orderitem->update($request->validated());
        return OrderitemResource::make($orderitem)
            ->additional([
                'msg' => 'Registro Actualizado Correctamente',
                'title' => 'Items de Ordenes de Venta',
                'Error' => 0,
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Orderitem $orderitem)
    {
        $orderitem->delete();
        return OrderitemResource::make($orderitem)
            ->additional([
                'msg' => 'Registro Eliminado',
                'title' => 'Items de Ordenes de Venta',
                'Error' => 0,
            ]);
    }
}
