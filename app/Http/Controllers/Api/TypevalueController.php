<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TypevalueResource;
use App\Models\Type;
use App\Models\Typevalue;
use Illuminate\Http\Request;

class TypevalueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (!$request->type) {
            return response()->json(['error' => 'Type is required'], 400);
        }
        $user = auth()->user();
        $company_id = $user->company_id;
        $type = Type::where('company_id', $company_id)
            ->where('name', $request->type)
            ->first();

        if ($type) {
            $data = Typevalue::where('type_id', $type->id)->get();
            return TypevalueResource::collection($data);
        } else {
            return response()->json(['error' => 'Type ' . $request->type . ', not found'], 404);
        }
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
    public function show(Typevalue $typevalue)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Typevalue $typevalue)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Typevalue $typevalue)
    {
        //
    }
}
