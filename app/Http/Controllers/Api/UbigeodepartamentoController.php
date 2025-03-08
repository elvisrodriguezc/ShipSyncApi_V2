<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UbigeodepartamentoResource;
use App\Models\Ubigeodepartamento;
use Illuminate\Http\Request;

class UbigeodepartamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Ubigeodepartamento::all();
        return UbigeodepartamentoResource::collection($data);
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
    public function show(Ubigeodepartamento $department)
    {
        return UbigeodepartamentoResource::make($department);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ubigeodepartamento $ubigeodepartamento)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ubigeodepartamento $ubigeodepartamento)
    {
        //
    }
}
