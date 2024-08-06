<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Sunatruc;
use App\Http\Requests\V1\StoreSunatrucRequest;
use App\Http\Requests\V1\UpdateSunatrucRequest;
use App\Http\Resources\V1\SunatrucResource;
use Illuminate\Http\Request;


class SunatrucController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = Sunatruc::limit(20)
            ->get();

        return SunatrucResource::collection($data)
            ->additional([
                'msg' => 'Listado correcto',
                'title' => 'Categorias',
                'Error' => 0,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSunatrucRequest $request)
    {
        $formData = $request->validated();
        $data = Sunatruc::create($formData);
        return SunatrucResource::make($data)
            ->additional([
                'msg' => 'Registro Creado Correctamente',
                'title' => 'Categorias',
                'Error' => 0,
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Sunatruc $sunatruc)
    {
        return SunatrucResource::make($sunatruc);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSunatrucRequest $request, Sunatruc $sunatruc)
    {
        $sunatruc->update($request->validated());
        return SunatrucResource::make($sunatruc)
            ->additional([
                'msg' => 'Registro Actualizado Correctamente',
                'title' => 'Categorias',
                'Error' => 0,
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sunatruc $sunatruc)
    {
        $sunatruc->delete();
        return SunatrucResource::make($sunatruc)
            ->additional([
                'msg' => 'Registro Eliminado',
                'title' => 'Categorias',
                'Error' => 0,
            ]);
    }
    public function searchByRuc($ruc)
    {
        try {
            $query = Sunatruc::where('ruc', $ruc)->firstOrFail();

            return SunatrucResource::make($query)->additional([
                'msg' => 'Extraído del Padrón SUNAT',
                'find' => $ruc,
                'Error' => 0,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'data' => [],
                'msg' => 'Error en la búsqueda, no se encotró el RUC',
                'find' => $ruc,
                'Error' => 1,
            ], 404);
        }
    }
}
