<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreServicedetspentRequest;
use App\Http\Resources\V1\ServicedetspentResource;
use App\Models\Servicedetspent;
use Illuminate\Http\Request;

class ServicedetspentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Servicedetspent::get();
        return ServicedetspentResource::collection($data)
            ->additional([
                'msg' => 'Listado correcto',
                'title' => 'Servicios',
                'Error' => 0,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServicedetspentRequest $request)
    {
        $formData = $request->validated();
        $data = Servicedetspent::create($formData);
        return ServicedetspentResource::make($data)
            ->additional([
                'msg' => 'Registro Creado Correctamente',
                'title' => 'Gastos del Servicio',
                'Error' => 0,
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Servicedetspent $servicedetspent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Servicedetspent $servicedetspent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Servicedetspent $servicedetspent)
    {
        //
    }
}
