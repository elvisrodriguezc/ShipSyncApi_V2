<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\EntitiebranchResource;
use App\Models\Entitiebranch;
use Illuminate\Http\Request;

class EntitiebranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Entitiebranch::get();

        return EntitiebranchResource::collection($query)
            ->additional([
                'msg' => 'Listado correcto',
                'title' => 'Guias de Remisión Transportista',
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
    public function show(Entitiebranch $entitiebranch)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Entitiebranch $entitiebranch)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Entitiebranch $entitiebranch)
    {
        //
    }
}
