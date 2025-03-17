<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Http\Resources\RoleResource;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $data = Role::where('company_id', $user->company_id)->get();
        return RoleResource::collection($data)
            ->additional([
                'meta' => [
                    'total' => $data->count(),
                ]
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request)
    {
        $user = auth()->user();
        $request->validated();
        $role = new Role($request->all());
        $role->company_id = $user->company_id;
        $role->save();

        return RoleResource::make($role)->additional([
            'message' => 'Rol creado correctamente',
            'error' => 0,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        return RoleResource::make($role);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        $request->validated();
        $role->update($request->all());

        return RoleResource::make($role)->additional([
            'message' => 'Rol actualizado correctamente',
            'error' => 0,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role->delete();

        return RoleResource::make($role)->additional([
            'message' => 'Rol eliminado correctamente',
            'error' => 0,
        ]);
    }
}
