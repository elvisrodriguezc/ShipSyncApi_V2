<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreGuidecarrierRequest;
use App\Http\Requests\V1\UpdateGuidecarrierRequest;
use App\Http\Resources\V1\GuidecarrierResource;
use App\Models\Guidecarrier;
use App\Models\Guidecarrierdocs;
use App\Models\Guidecarrieritem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuidecarrierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $query = Guidecarrier::where('company_id', $user->company_id)
            ->get();

        return GuidecarrierResource::collection($query)
            ->additional([
                'msg' => 'Listado correcto',
                'title' => 'Guias de Remisión Transportista',
                'Error' => 0,
            ]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGuidecarrierRequest $request)
    {
        $formData = $request->validated();
        $query = Guidecarrier::create($formData);

        foreach ($request->items as $item) {
            Guidecarrieritem::create([
                'guidecarrier_id' => $query->id,
                'product_id' => $item["product_id"],
                'quantity' => $item['quantity'],
                'unity_id' => $item['unity_id'],
            ]);
        }
        foreach ($request->documents as $document) {
            Guidecarrierdocs::create([
                'guidecarrier_id' => $query->id,
                'ruc' => $document["ruc"],
                'serie' => $document['serie'],
                'number' => $document['numero'],
                'tipocpe_id' => $document['tipocpe'],
            ]);
        }
        return GuidecarrierResource::make($query)
            ->additional([
                'msg' => 'Registro Creado Correctamente',
                'title' => 'Marcas',
                'Error' => 0,
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Guidecarrier $guidecarrier)
    {

        return GuidecarrierResource::make($guidecarrier)
            ->additional([
                'msg' => 'Registro Creado Correctamente',
                'title' => 'Marcas',
                'Error' => 0,
            ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGuidecarrierRequest $request, Guidecarrier $guidecarrier)
    {
        $guidecarrier->update($request->validated());
        return GuidecarrierResource::make($guidecarrier)
            ->additional([
                'msg' => 'Registro Actualizado Correctamente',
                'title' => 'Guias de Remision Transportista',
                'Error' => 0,
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Guidecarrier $guidecarrier)
    {
        //
    }
}
