<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\UpdateOrderserviceitemRequest;
use App\Http\Resources\V1\OrderserviceitemResource;
use App\Models\Orderserviceitem;
use Illuminate\Http\Request;

class OrderserviceitemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Orderserviceitem $orderserviceitem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderserviceitemRequest $request, Orderserviceitem $orderserviceitem)
    {
        $orderserviceitem->update($request->validated());
        return OrderserviceitemResource::make($orderserviceitem)
            ->additional([
                'msg' => 'Registro Actualizado Correctamente',
                'title' => 'Órdenes de Servicio Item',
                'Error' => 0,
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Orderserviceitem $orderserviceitem)
    {
        //
    }
}
