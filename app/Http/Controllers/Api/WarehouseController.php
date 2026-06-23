<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWarehouseRequest;
use App\Http\Requests\UpdateWarehouseRequest;
use App\Http\Resources\WarehouseResource;
use App\Models\Headquarter;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $company_id = auth()->user()->company_id;
        $headquarter_id = auth()->user()->headquarter_id;
        $headquarters = Headquarter::where('company_id', $company_id)->get()->pluck('id')->toArray();
        $warehouses = Warehouse::whereIn('headquarter_id', $headquarters)->get();

        if ($request->has('mode') && $request->mode == "headquarter") {
            $warehouses = Warehouse::where('headquarter_id', $headquarter_id)->get();
        }
        return WarehouseResource::collection($warehouses);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWarehouseRequest $request)
    {
        $request->validated();
        $headquarter = Headquarter::where('company_id', auth()->user()->company_id)->findOrFail($request->headquarter_id);
        $newWarehouse = Warehouse::create($request->all());
        return WarehouseResource::make($newWarehouse);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $warehouse = Warehouse::whereHas('headquarter', function ($q) {
            $q->where('company_id', auth()->user()->company_id);
        })->findOrFail($id);
        return new WarehouseResource($warehouse);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWarehouseRequest $request, $id)
    {
        $request->validated();
        $warehouse = Warehouse::whereHas('headquarter', function ($q) {
            $q->where('company_id', auth()->user()->company_id);
        })->findOrFail($id);
        $warehouse->update($request->all());
        return WarehouseResource::make($warehouse);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $warehouse = Warehouse::whereHas('headquarter', function ($q) {
            $q->where('company_id', auth()->user()->company_id);
        })->findOrFail($id);
        $warehouse->delete();
        return WarehouseResource::make($warehouse);
    }
}
