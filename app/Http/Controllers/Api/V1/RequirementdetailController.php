<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreRequirementdetailRequest;
use App\Http\Requests\V1\UpdateRequirementdetailRequest;
use App\Http\Resources\V1\RequirementdetailResource;
use App\Models\Requirementdetail;

class RequirementdetailController extends Controller
{
    public function index()
    {
        $query = Requirementdetail::get();
        return RequirementdetailResource::collection($query)
            ->additional([
                'msg' => 'Listado satisfactorio',
                'title' => 'Items del Items del Requerimiento',
                'Error' => 0,
            ]);
    }
    public function store(StoreRequirementdetailRequest $request)
    {
        $newRequirementdetail = Requirementdetail::create($request->validated());
        return RequirementdetailResource::make($newRequirementdetail)
            ->additional([
                'msg' => 'Registro Creado Correctamente',
                'title' => 'Items del Requerimiento',
                'Error' => 0,
            ]);
    }
    public function show(Requirementdetail $requirementdetail)
    {
        return RequirementdetailResource::make($requirementdetail);
    }
    public function update(UpdateRequirementdetailRequest $request, Requirementdetail $requirementdetail)
    {
        $requirementdetail->update($request->all());
        return RequirementdetailResource::make($requirementdetail)
            ->additional([
                'msg' => 'Registro Actualizado Correctamente',
                'title' => 'Items del Requerimiento',
                'Error' => 0,
            ]);
    }
    public function destroy(Requirementdetail $requirementdetail)
    {
        $requirementdetail->delete();
        return RequirementdetailResource::make($requirementdetail)
            ->additional([
                'msg' => 'Registro Eliminado',
                'title' => 'Items del Requerimiento',
                'Error' => 0,
            ]);
    }
}
