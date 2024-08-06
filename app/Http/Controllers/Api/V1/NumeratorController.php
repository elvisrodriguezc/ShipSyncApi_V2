<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreNumeratorRequest;
use App\Http\Requests\V1\UpdateNumeratorRequest;
use App\Http\Resources\V1\NumeratorResource;
use App\Models\Numerator;
use App\Models\Office;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NumeratorController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $offices = Office::where('company_id', $user->company_id)->pluck('id');

        $query = Numerator::whereIn('office_id', $offices)
            ->get();

        return NumeratorResource::collection($query)
            ->additional([
                'msg' => 'Listado satisfactorio',
                'title' => 'Series',
                'Error' => 0,
            ]);
    }


    public function store(StoreNumeratorRequest $request)
    {
        $newNumerator = Numerator::create($request->validated());
        return NumeratorResource::make($newNumerator)
            ->additional([
                'msg' => 'Registro Creado Correctamente',
                'title' => 'Requerimiento',
                'Error' => 0,
            ]);
    }
    public function show(Numerator $requirement)
    {
        return NumeratorResource::make($requirement);
    }
    public function update(UpdateNumeratorRequest $request, Numerator $requirement)
    {
        $requirement->update($request->all());
        return NumeratorResource::make($requirement)
            ->additional([
                'msg' => 'Registro Actualizado Correctamente',
                'title' => 'Requerimiento',
                'Error' => 0,
            ]);
    }
    public function destroy(Numerator $requirement)
    {
        $requirement->delete();
        return NumeratorResource::make($requirement)
            ->additional([
                'msg' => 'Registro Eliminado',
                'title' => 'Requerimiento',
                'Error' => 0,
            ]);
    }
}
