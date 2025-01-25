<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StorePayrollUserRequest;
use App\Http\Requests\V1\StoreUserRequest;
use App\Http\Requests\V1\UpdateUserRequest;
use App\Http\Resources\V1\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $user = Auth::user();
        $query = User::where('company_id', $user->company_id)
            ->get();

        return UserResource::collection($query)
            ->additional([
                'msg' => 'Listado correcto',
                'title' => 'Categorias',
                'Error' => 0,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $user = Auth::user();
        $formData = $request->validated();
        $formData['company_id'] = $user->company_id; // Add the company_id
        $order = User::create($formData);

        return UserResource::make($order)
            ->additional([
                'msg' => 'Registro Creado Correctamente',
                'title' => 'Usuario nuevo',
                'Error' => 0,
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return UserResource::make($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        $formData = $request->validated();
        $user = User::find($id);
        $user->update($formData);
        return UserResource::make($user)
            ->additional([
                'msg' => 'Registro Actualizado Correctamente',
                'title' => 'Usuario',
                'Error' => 0,
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        $user->delete();
        return UserResource::make($user)
            ->additional([
                'msg' => 'Registro Eliminado Correctamente',
                'title' => 'Usuario',
                'Error' => 0,
            ]);
    }
}
