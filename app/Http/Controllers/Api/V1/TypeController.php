<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreTypeRequest;
use App\Http\Requests\V1\UpdateTypeRequest;
use App\Http\Resources\V1\TypeResource;
use App\Models\Type;
use Illuminate\Support\Facades\Auth;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Type::get();

        return TypeResource::collection($data)
            ->additional([
                'msg' => 'Listado correcto',
                'title' => 'Tipos de dato',
                'Error' => 0,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTypeRequest $request)
    {
        $user = Auth::user();
        $formData = $request->validated();
        $formData['company_id'] = $user->company_id; // Add the company_id field with user company
        $data = Type::create($formData);
        return TypeResource::make($data)
            ->additional([
                'msg' => 'Registro Creado Correctamente',
                'title' => 'Tipos de dato',
                'Error' => 0,
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Type $tipo)
    {
        return TypeResource::make($tipo)
            ->additional([
                'msg' => 'Registro actual',
                'title' => 'Tipos de dato',
                'Error' => 0,
            ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTypeRequest $request, Type $type)
    {
        $formData = $request->validated();
        $type->update($formData);

        return TypeResource::make($type)
            ->additional([
                'msg' => 'Registro Actualizado Correctamente',
                'title' => 'Tipos de dato',
                'Error' => 0,
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Type $type)
    {
        $type->delete();
        return TypeResource::make($type)
            ->additional([
                'msg' => 'Registro Actualizado Correctamente',
                'title' => 'Tipos de dato',
                'Error' => 0,
            ]);
    }
}
