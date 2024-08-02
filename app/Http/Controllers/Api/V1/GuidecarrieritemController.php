<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreGuidecarrieritemRequest;
use App\Http\Resources\V1\GuidecarrieritemResource;
use App\Models\Guidecarrieritem;
use Illuminate\Http\Request;

class GuidecarrieritemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Guidecarrieritem::get();
        return GuidecarrieritemResource::collection($query)
            ->additional([
                'msg' => 'Listado correcto',
                'title' => 'Categorias',
                'Error' => 0,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGuidecarrieritemRequest $request)
    {
        $formData = $request->validated();
        $query = Guidecarrieritem::create($formData);

        return GuidecarrieritemResource::make($query)
            ->additional([
                'msg' => 'Registro Creado Correctamente',
                'title' => 'Items de Guía',
                'Error' => 0,
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Guidecarrieritem $guidecarrieritem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Guidecarrieritem $guidecarrieritem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Guidecarrieritem $guidecarrieritem)
    {
        //
    }
}
