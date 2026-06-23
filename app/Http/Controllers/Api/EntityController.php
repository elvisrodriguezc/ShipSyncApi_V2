<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEntityRequest;
use App\Http\Requests\UpdateEntityRequest;
use App\Http\Resources\EntityResource;
use App\Models\Entity;
use Illuminate\Http\Request;

class EntityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $company_id = $user->company_id;
        $query = Entity::where('company_id', $company_id);
        if ($request->has('mode')) {
            if ($request->mode === 'customers') {
                $query->where('mode', 'like', '%C%');
            } elseif ($request->mode === 'suppliers') {
                $query->where('mode', 'like', '%P%');
            }
        }
        $data = $query->get();

        return EntityResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEntityRequest $request)
    {
        $user = auth()->user();
        $company_id = $user->company_id;
        $data = $request->validated();
        $data['company_id'] = $company_id;
        $entity = Entity::create($data);

        return EntityResource::make($entity);
    }

    /**
     * Display the specified resource.
     */
    public function show(Entity $entity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEntityRequest $request, Entity $entity)
    {
        $entity->update($request->validated());
        return EntityResource::make($entity);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Entity $entity)
    {
        $entity->delete();
        return response()->json(['message' => 'Proveedor eliminado correctamente']);
    }
}
