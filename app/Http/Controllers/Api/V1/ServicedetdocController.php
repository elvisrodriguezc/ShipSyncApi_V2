<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\ServicedetdocResource;
use App\Models\Servicedetdoc;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class ServicedetdocController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = QueryBuilder::for(Servicedetdoc::class)
            ->get();

        return ServicedetdocResource::collection($data)
            ->additional([
                'msg' => 'Listado correcto',
                'title' => 'Detalle de Documentos de Servicios',
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
    public function show(Servicedetdoc $servicedetdoc)
    {
        return ServicedetdocResource::make($servicedetdoc);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Servicedetdoc $servicedetdoc)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Servicedetdoc $servicedetdoc)
    {
        //
    }
}
