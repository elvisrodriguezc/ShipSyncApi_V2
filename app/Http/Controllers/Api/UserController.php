<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    // Change Password
    public function changePassword(Request $request, $id)
    {
        $request->validate([
            // 'password' => 'required|string',
            'new_password' => 'required|string',
        ]);

        // if (!password_verify($request->password, $user->password)) {
        //     return response()->json([
        //         'message' => 'La contraseña actual no es correcta',
        //         'error' => 1,
        //     ], 400);
        // }

        $user = User::where('company_id', auth()->user()->company_id)->findOrFail($id);
        $user->password = bcrypt($request->new_password);
        $user->save();

        return UserResource::make($user)->additional([
            'message' => 'Contraseña actualizada correctamente',
            'error' => 0,
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $company_id = auth()->user()->company_id;
        $data = User::where('company_id', $company_id)
            ->with(['company', 'headquarter', 'role', 'roles', 'document', 'contact'])
            ->where('status', 1)
            ->get();
        return UserResource::collection($data)->additional(['meta' => [
            'total' => $data->count(),
        ]]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $request->validated();
        $company_id = auth()->user()->company_id;
        $user = new User($request->all());
        $user->company_id = $company_id;
        $user->password = bcrypt($request->password);

        if (!$user->role_id && $request->has('roles') && count($request->roles) > 0) {
            $user->role_id = $request->roles[0];
        }

        $user->save();

        if ($request->has('roles')) {
            $user->roles()->sync($request->roles);
        }

        $user->load(['company', 'headquarter', 'role', 'roles', 'document', 'contact']);

        return UserResource::make($user)->additional([
            'message' => 'Usuario creado correctamente',
            'error' => 0,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::where('company_id', auth()->user()->company_id)->findOrFail($id);
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $request->validated();
        $user = User::where('company_id', auth()->user()->company_id)->findOrFail($id);

        $data = $request->all();
        if ((!isset($data['role_id']) || !$data['role_id']) && $request->has('roles') && count($request->roles) > 0) {
            $data['role_id'] = $request->roles[0];
        }

        $user->update($data);

        if ($request->has('roles')) {
            $user->roles()->sync($request->roles);
        }

        $user->load(['company', 'headquarter', 'role', 'roles', 'document', 'contact']);

        return UserResource::make($user)->additional([
            'message' => 'Usuario actualizado correctamente',
            'error' => 0,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::where('company_id', auth()->user()->company_id)->findOrFail($id);
        $user->delete();
        return UserResource::make($user)->additional([
            'message' => 'Usuario eliminado correctamente',
            'error' => 0,
        ]);
    }
}
