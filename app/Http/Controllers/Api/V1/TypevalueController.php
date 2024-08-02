<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreTypevalueRequest;
use App\Http\Requests\V1\UpdateTypevalueRequest;
use App\Http\Resources\V1\TypevalueResource;
use App\Models\Typevalue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TypevalueController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $data = Typevalue::where('type_id', $request->type)
            ->get();

        return TypevalueResource::collection($data)
            ->additional([
                'msg' => 'Listado correcto',
                'title' => 'Entidades1',
                'Error' => 0,
            ]);
    }
    public function store(StoreTypevalueRequest $request)
    {
        $formData = $request->validated();
        $data = Typevalue::create($formData);
        return TypevalueResource::make($data)
            ->additional([
                'msg' => 'Registro Creado Correctamente',
                'title' => 'Valor Tipo',
                'Error' => 0,
            ]);
    }
    public function show(Typevalue $typevalue)
    {
        return TypevalueResource::make($typevalue);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTypevalueRequest $request, Typevalue $typevalue)
    {
        $formData = $request->validated();
        $typevalue->update($formData);

        return TypevalueResource::make($typevalue)
            ->additional([
                'msg' => 'Registro Actualizado Correctamente',
                'title' => 'Valor Tipo',
                'Error' => 0,
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Typevalue $typevalue)
    {
        $typevalue->delete();

        return response()->json([
            'msg' => 'Registro Eliminado Correctamente',
            'title' => 'Valor Tipo',
            'Error' => 0,
        ]);
    }
}
