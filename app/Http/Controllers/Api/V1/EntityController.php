<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Entity;
use App\Http\Requests\V1\StoreEntityRequest;
use App\Http\Requests\V1\UpdateEntityRequest;
use App\Http\Resources\V1\EntityResource;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;

class EntityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $data = QueryBuilder::for(Entity::class)
            ->allowedFilters(['text'])
            ->defaultSort('-created_at')
            ->allowedSorts(['text'])
            ->where('company_id', $user->company_id)
            ->get();

        return EntityResource::collection($data)
            ->additional([
                'msg' => 'Listado correcto',
                'title' => 'Entidades1',
                'Error' => 0,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEntityRequest $request)
    {
        $user = Auth::user();
        $formData = $request->validated();
        $formData['company_id'] = $user->company_id; // Add the company_id field with user company
        $data = Entity::create($formData);
        return EntityResource::make($data)
            ->additional([
                'msg' => 'Registro Creado Correctamente',
                'title' => 'Entidades',
                'Error' => 0,
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Entity $entidades)
    {
        return EntityResource::make($entidades);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEntityRequest $request, Entity $entidades)
    {
        $entidades->update($request->validated());
        return EntityResource::make($entidades)
            ->additional([
                'msg' => 'Registro Actualizado Correctamente',
                'title' => 'Entidades',
                'Error' => 0,
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Entity $entidades)
    {
        $entidades->delete();
        return EntityResource::make($entidades)
            ->additional([
                'msg' => 'Registro Eliminado',
                'title' => 'Entidades',
                'Error' => 0,
            ]);
    }

    public function searchByIdFormNumber($number)
    {
        try {
            $data = QueryBuilder::for(Entity::class)
                ->where('idform_number', $number)
                ->firstOrFail();

            return EntityResource::make($data)
                ->additional([
                    'msg' => 'Busqueda satisfactoria',
                    'find' => $number,
                    'Error' => 0,
                ]);
        } catch (\Exception $e) {
            return response()->json([
                'msg' => 'Error en la búsqueda',
                'find' => $number,
                'Error' => 1,
            ], 404);
        }
    }
}
