<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUnitRequest;
use App\Http\Requests\UpdateUnitRequest;
use App\Http\Resources\UnitResource;
use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $company_id = auth()->user()->company_id;
        $units = Unit::where('company_id', $company_id)
            ->orderby('name', 'asc')
            ->get();
        return UnitResource::collection($units)->additional([
            'meta' => [
                'total' => $units->count(),
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUnitRequest $request)
    {
        $request->validated();
        $unit = Unit::create([
            'company_id' => auth()->user()->company_id,
            'name' => $request->name,
            'symbol' => $request->symbol,
            'value' => $request->value,
            'status' => $request->status,
        ]);
        return UnitResource::make($unit)->additional([
            'meta' => [
                'message' => 'Unit created successfully',
            ],
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Unit $unit)
    {
        return UnitResource::make($unit)->additional([
            'meta' => [
                'message' => 'Unit retrieved successfully',
            ],
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUnitRequest $request, Unit $unit)
    {
        $request->validated();
        $unit->update([
            'name' => $request->name,
            'symbol' => $request->symbol,
            'value' => $request->value,
            'status' => $request->status,
        ]);
        return UnitResource::make($unit)->additional([
            'meta' => [
                'message' => 'Unit updated successfully',
            ],
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Unit $unit)
    {
        $unit->delete();
        return UnitResource::make($unit)->additional([
            'meta' => [
                'message' => 'Unit deleted successfully',
            ],
        ]);
    }
}
