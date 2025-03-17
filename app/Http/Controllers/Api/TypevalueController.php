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
        if ($request->has('type')) {
            $type_id = Type::where('name', $request->type)->first()->id;
            $typevalues = Typevalue::where('type_id', $type_id)
                ->orderBy('name')
                ->get();
            return TypevalueResource::collection($typevalues);
        } else {
            $typevalues = Typevalue::orderBy('name')
                ->get();
            return response()->json([
                'message' => 'Please provide a type parameter',
                'error' => 1
            ], 400); // 400 Bad Request
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
    public function show(Typevalue $typevalue)
    {
        return TypevalueResource::make($typevalue);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTypevalueRequest $request, Typevalue $typevalue)
    {
        $data = $request->validated();
        $typevalue->update($data);
        return TypevalueResource::make($typevalue);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Typevalue $typevalue)
    {
        try {
            $typevalue->delete();
            return TypevalueResource::make($typevalue)
                ->additional([
                    'message' => 'Typevalue deleted successfully',
                    'error' => 0
                ]);
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1] ?? null;
            if ($errorCode == 1451) { // MySQL foreign key constraint error
                return response()->json([
                    'message' => 'Typevalue cannot be deleted because it is related to other records',
                    'error' => 1
                ], 423); // 423 Locked
            }

            return response()->json([
                'message' => 'An error occurred while deleting the typevalue',
                'error' => 1
            ], 500);
        }
    }
}
