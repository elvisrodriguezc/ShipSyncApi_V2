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
        $data = Role::where('company_id', $user->company_id)->with(['permissions', 'menus'])->get();
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

        if ($request->has('permissions')) {
            $role->permissions()->sync($request->permissions);
        }

        $role->load(['permissions', 'menus']);

        return RoleResource::make($role)->additional([
            'message' => 'Rol creado correctamente',
            'error' => 0,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $role = Role::where('company_id', auth()->user()->company_id)->with(['permissions', 'menus'])->findOrFail($id);
        return RoleResource::make($role);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, $id)
    {
        $request->validated();
        $role = Role::where('company_id', auth()->user()->company_id)->with(['permissions', 'menus'])->findOrFail($id);
        $role->update($request->all());

        if ($request->has('permissions')) {
            $role->permissions()->sync($request->permissions);
        }

        $role->load(['permissions', 'menus']);

        return RoleResource::make($role)->additional([
            'message' => 'Rol actualizado correctamente',
            'error' => 0,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $role = Role::where('company_id', auth()->user()->company_id)->findOrFail($id);
        $role->delete();

        return RoleResource::make($role)->additional([
            'message' => 'Rol eliminado correctamente',
            'error' => 0,
        ]);
    }
}
