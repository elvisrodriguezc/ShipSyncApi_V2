<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\WarehousestockResource;
use App\Models\Warehousestock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WarehousestockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $user = Auth::user();
        $data = Warehousestock::where('company_id', $user->company_id)
            ->orderby('warehouse_id')
            ->get();

        if ($request->office) {
            if ($request->product) {
                $data = Warehousestock::where('office_id', $request->office)
                    ->where('product_id', $request->product)
                    ->get();
            } else {
                $data = Warehousestock::where('office_id', $request->office)
                    ->orderby('warehouse_id')
                    ->get();
            }
        }
        if ($request->warehouse) {
            if ($request->product) {
                $data = Warehousestock::where('warehouse_id', $request->warehouse)
                    ->where('product_id', $request->product)
                    ->get();
            } else {
                $data = Warehousestock::where('warehouse_id', $request->warehouse)
                    ->get();
            }
        }
        // if ($request->ware) {
        //     $data = Warehouse::where('office_id', $request->office)
        //         ->get();
        // } else {
        //     return $data = response()->json([
        //         "data" => "Ups, Houston, I don't know what do you need. Please espedify the Office parameter and a value",
        //         "message" => "Error",
        //         "error" => 1
        //     ], 400);
        // }

        return WarehousestockResource::collection($data)
            ->additional([
                'msg' => 'Listado correcto',
                'title' => 'Almacenes',
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
    public function show(Warehousestock $warehousestock)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Warehousestock $warehousestock)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Warehousestock $warehousestock)
    {
        //
    }
}
