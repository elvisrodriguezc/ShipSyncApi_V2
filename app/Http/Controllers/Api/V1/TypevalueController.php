<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\TypevalueResource;
use App\Models\Typevalue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;

class TypevalueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $data = QueryBuilder::for(Typevalue::class)
            ->where('type_id', $request->type)
            ->get();

        return TypevalueResource::collection($data)
            ->additional([
                'msg' => 'Listado correcto',
                'title' => 'Entidades1',
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
