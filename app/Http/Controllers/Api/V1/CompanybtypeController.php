<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreCompanybtypeRequest;
use App\Http\Resources\V1\CompanybtypeResource;
use App\Models\Company;
use App\Models\Companybtype;
use Illuminate\Http\Request;

class CompanybtypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Companybtype::get();
        return CompanybtypeResource::collection($data)
            ->additional([
                'msg' => 'Listado correcto',
                'title' => 'Tipos de Compañias',
                'Error' => 0,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompanybtypeRequest $request)
    {
        $companybtype = Companybtype::create($request->validate());
        return CompanybtypeResource::make($companybtype)
            ->additional([
                'msg' => 'Registro Creado Correctamente',
                'title' => 'Tipos de Compañias',
                'Error' => 0,
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Companybtype $companybtype)
    {
        return CompanybtypeResource::make($companybtype);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Companybtype $companybtype)
    {
        $companybtype->update($request->validate());
        return CompanybtypeResource::make($companybtype)
            ->additional([
                'msg' => 'Registro Actualizado Correctamente',
                'title' => 'Tipos de Compañias',
                'Error' => 0,
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Companybtype $companybtype)
    {
        $companybtype->delete();
        return CompanybtypeResource::make($companybtype)
            ->additional([
                'msg' => 'Registro Eliminado Correctamente',
                'title' => 'Tipos de Compañias',
                'Error' => 0,
            ]);
    }
}
