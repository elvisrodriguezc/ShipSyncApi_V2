<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\WarehousekardexResource;
use App\Models\Warehousekardex;
use Illuminate\Http\Request;

class WarehousekardexController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = Warehousekardex::where('warehouse_id', $request->warehouse)
            ->where('product_id', $request->product)
            ->orderby('id', 'desc')
            ->get();

        return WarehousekardexResource::collection($data)
            ->additional([
                'msg' => 'Listado correcto',
                'title' => 'Kardex',
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
    public function show(Warehousekardex $warehousekardex)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Warehousekardex $warehousekardex)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Warehousekardex $warehousekardex)
    {
        //
    }
}
