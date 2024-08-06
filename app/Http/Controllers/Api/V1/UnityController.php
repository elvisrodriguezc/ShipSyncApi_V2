<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreUnityRequest;
use App\Http\Requests\V1\UpdateUnityRequest;
use App\Http\Resources\V1\UnityResource;
use App\Models\Unity;
use Illuminate\Support\Facades\Auth;


class UnityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $unities = Unity::orderBy('name')
            ->get();
        return UnityResource::collection($unities)
            ->additional([
                'msg' => 'Listado correcto',
                'title' => 'Unidades',
                'Error' => 0,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUnityRequest $request)
    {
        // dd($request->validated());
        $unity = Unity::create($request->validated());
        return UnityResource::make($unity)
            ->additional([
                'msg' => 'Registro Creado Correctamente',
                'title' => 'Unidades',
                'Error' => 0,
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Unity $unity)
    {
        return UnityResource::make($unity);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUnityRequest $request, Unity $unity)
    {
        $unity->update($request->validated());
        return UnityResource::make($unity)
            ->additional([
                'msg' => 'Registro Actualizado Correctamente',
                'title' => 'Unidades',
                'Error' => 0,
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Unity $unity)
    {
        $unity->delete();
        return UnityResource::make($unity)
            ->additional([
                'msg' => 'Registro Eliminado',
                'title' => 'Unidades',
                'Error' => 0,
            ]);
    }
}
