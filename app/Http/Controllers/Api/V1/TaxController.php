<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreTaxRequest;
use App\Http\Requests\V1\UpdateTaxRequest;
use App\Http\Resources\V1\TaxResource;
use App\Models\Tax;
use Illuminate\Http\Request;

class TaxController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Tax::all();
        return TaxResource::collection($query)
            ->additional([
                'msg' => 'Listado correcto',
                'title' => 'Impuestos',
                'Error' => 0,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaxRequest $request)
    {
        $formData = $request->validated();
        $tax = Tax::create($formData);
        return TaxResource::make($tax)
            ->additional([
                'msg' => 'Registro Creado Correctamente',
                'title' => 'Impuesto nuevo',
                'Error' => 0,
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tax $tax)
    {
        return TaxResource::make($tax);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaxRequest $request, Tax $tax)
    {
        $formData = $request->validated();
        $tax->update($formData);
        return TaxResource::make($tax)
            ->additional([
                'msg' => 'Registro Actualizado Correctamente',
                'title' => 'Impuesto',
                'Error' => 0,
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tax $tax)
    {
        $tax->delete();
        return TaxResource::make($tax)
            ->additional([
                'msg' => 'Registro Eliminado Correctamente',
                'title' => 'Impuesto' + $tax->name,
                'Error' => 0,
            ]);
    }
}
