<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreDatakeyRequest;
use App\Http\Requests\V1\UpdateDatakeyRequest;
use App\Http\Resources\V1\DatakeyResource;
use App\Models\Datakey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class DatakeyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $query = Datakey::where('company_id', $user->company_id)
            ->get();

        return DatakeyResource::collection($query)
            ->additional([
                'msg' => 'Listado correcto',
                'title' => 'Datakeys Transportista',
                'Error' => 0,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDatakeyRequest $request)
    {
        $user = Auth::user();
        $formData = $request->validated();
        $formData['company_id'] = $user->company_id; // Agregar el campo company_id con el valor de la Empresa del usuario
        $formData['content'] =  Crypt::encryptString($request->content);
        $query = Datakey::create($formData);

        return DatakeyResource::make($query)
            ->additional([
                'msg' => 'Registro Creado Correctamente',
                'title' => 'DataKey',
                'Error' => 0,
            ]);
    }

    public function show(Datakey $datakey)
    {
        return DatakeyResource::make($datakey)
            ->additional([
                'msg' => 'Registro Creado Correctamente',
                'title' => 'Datakey',
                'Error' => 0,
            ]);
    }

    public function update(UpdateDatakeyRequest $request, Datakey $datakey)
    {
        $formData = $request->validated();
        $formData['content'] = Crypt::encryptString($request->content);
        if ($request['content']) {
            $datakey->update($formData);
        }
        return DatakeyResource::make($datakey)
            ->additional([
                'msg' => 'Registro Actualizado Correctamente',
                'title' => 'Datakey',
                'Error' => 0,
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Datakey $datakey)
    {
        //
    }
}
