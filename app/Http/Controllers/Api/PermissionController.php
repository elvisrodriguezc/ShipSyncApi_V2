<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        $companyId = auth()->user()->company_id;
        $data = Permission::where('company_id', $companyId)->get();
        return response()->json($data);
    }

    public function store(StorePermissionRequest $request)
    {
        $request->validated();
        $companyId = auth()->user()->company_id;
        $permission = new Permission($request->all());
        $permission->company_id = $companyId;
        $permission->save();

        return response()->json($permission->load('roles'));
    }

    public function show($id)
    {
        $permission = Permission::where('company_id', auth()->user()->company_id)->findOrFail($id);
        return response()->json($permission->load('roles'));
    }

    public function update(UpdatePermissionRequest $request, $id)
    {
        $request->validated();
        $permission = Permission::where('company_id', auth()->user()->company_id)->findOrFail($id);
        $permission->update($request->all());

        return response()->json($permission->fresh()->load('roles'));
    }

    public function destroy($id)
    {
        $permission = Permission::where('company_id', auth()->user()->company_id)->findOrFail($id);
        $permission->delete();

        return response()->json(['message' => 'Permiso eliminado correctamente']);
    }
}
