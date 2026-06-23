<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTypevalueRequest;
use App\Http\Requests\UpdateTypevalueRequest;
use App\Http\Resources\TypevalueResource;
use App\Models\Type;
use App\Models\Typevalue;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class TypevalueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $company_id = auth()->user()->company_id;
        if ($request->has('type')) {
            $type_id = Type::where('name', $request->type)->where('company_id', $company_id)->firstOrFail()->id;
            $typevalues = Typevalue::where('type_id', $type_id)
                ->orderBy('name')
                ->get();
            return TypevalueResource::collection($typevalues);
        } else {
            return response()->json([
                'message' => 'Please provide a type parameter',
                'error' => 1
            ], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTypevalueRequest $request)
    {
        $data = $request->validated();
        $typevalue = Typevalue::create($data);
        return TypevalueResource::make($typevalue);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $typevalue = Typevalue::findOrFail($id);
        return TypevalueResource::make($typevalue);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTypevalueRequest $request, $id)
    {
        $data = $request->validated();
        $typevalue = Typevalue::findOrFail($id);
        $typevalue->update($data);
        return TypevalueResource::make($typevalue);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $typevalue = Typevalue::findOrFail($id);
            $typevalue->delete();
            return TypevalueResource::make($typevalue)
                ->additional([
                    'message' => 'Typevalue deleted successfully',
                    'error' => 0
                ]);
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1] ?? null;
            if ($errorCode == 1451) {
                return response()->json([
                    'message' => 'Typevalue cannot be deleted because it is related to other records',
                    'error' => 1
                ], 423);
            }

            return response()->json([
                'message' => 'An error occurred while deleting the typevalue',
                'error' => 1
            ], 500);
        }
    }
}
