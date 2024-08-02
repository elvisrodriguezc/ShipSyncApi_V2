<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\OrderserviceResource;
use App\Models\Orderservice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderserviceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $query = Orderservice::where('warehouse_id', $user->warehouse_id)
            ->get();

        return OrderserviceResource::collection($query)
            ->additional([
                'msg' => 'Listado correcto',
                'title' => 'Datakeys Transportista',
                'Error' => 0,
            ]);
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
    public function show(Orderservice $orderservice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Orderservice $orderservice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Orderservice $orderservice)
    {
        //
    }
}
