<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UbigeoprovinciaResource;
use App\Models\Ubigeoprovincia;
use Illuminate\Http\Request;

class UbigeoprovinciaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->has('department_id')) {
            $data = Ubigeoprovincia::where('ubigeodepartamento_id', $request->department_id)->get();
        } else {
            $data = Ubigeoprovincia::all();
        }
        return UbigeoprovinciaResource::collection($data);
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
    public function show(Ubigeoprovincia $province)
    {
        return UbigeoprovinciaResource::make($province);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ubigeoprovincia $ubigeoprovincia)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ubigeoprovincia $ubigeoprovincia)
    {
        //
    }
}
