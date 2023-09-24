<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Sunatruc;
use App\Http\Requests\V1\StoreSunatrucRequest;
use App\Http\Requests\V1\UpdateSunatrucRequest;
use App\Http\Resources\V1\SunatrucResource;
use Spatie\QueryBuilder\QueryBuilder;

class SunatrucController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = QueryBuilder::for(Sunatruc::class)
            ->allowedFilters(['text'])
            ->defaultSort('-created_at')
            ->allowedSorts(['text'])
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
            $data = QueryBuilder::for(Sunatruc::class)
                ->where('ruc', $ruc)
                ->firstOrFail();

            return SunatrucResource::make($data)
                ->additional([
                    'msg' => 'Extraido de SUNAT',
                    'find' => $ruc,
                    'Error' => 0,
                ]);
        } catch (\Exception $e) {
            return response()->json([
                'msg' => 'Error en la búsqueda',
                'find' => $ruc,
                'Error' => 1,
            ], 404);
        }
    }

    public function searchByRazon($razon)
    {
        // $results = Sunatruc::where('idFormNumber', 'LIKE', '%' . $name . '%')->get();
        $results = Sunatruc::where('idform_number', $razon)->get();


        // $data = QueryBuilder::for(Sunatruc::class)
        //     ->allowedFilters(['text'])
        //     ->defaultSort('-created_at')
        //     ->allowedSorts(['text'])
        //     ->where('company_id', $user->company_id)
        //     ->get();


        return response()->json([
            'message' => 'Búsqueda satisfactoria',
            'Número' => $razon,
            'data' => $results[0]
        ], 200);
    }
    public function searchByNombre($nombre)
    {
        // $results = Sunatruc::where('idFormNumber', 'LIKE', '%' . $name . '%')->get();
        $results = Sunatruc::where('idform_number', $nombre)->get();


        // $data = QueryBuilder::for(Sunatruc::class)
        //     ->allowedFilters(['text'])
        //     ->defaultSort('-created_at')
        //     ->allowedSorts(['text'])
        //     ->where('company_id', $user->company_id)
        //     ->get();


        return response()->json([
            'message' => 'Búsqueda satisfactoria',
            'Número' => $nombre,
            'data' => $results[0]
        ], 200);
    }
}
