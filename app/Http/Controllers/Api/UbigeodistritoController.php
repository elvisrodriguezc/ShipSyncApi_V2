<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UbigeodistritoResource;
use App\Models\Ubigeodistrito;
use Illuminate\Http\Request;

class UbigeodistritoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->has('province_id')) {
            $data = Ubigeodistrito::where('ubigeoprovincia_id', $request->province_id)->get();
        } else {
            $data = Ubigeodistrito::all();
        }
        return UbigeodistritoResource::collection($data);
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
    public function show(Ubigeodistrito $ubigeodistrito)
    {
        return UbigeodistritoResource::make($ubigeodistrito);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ubigeodistrito $ubigeodistrito)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ubigeodistrito $ubigeodistrito)
    {
        //
    }
}
