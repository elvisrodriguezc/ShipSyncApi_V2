<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreRequirementRequest;
use App\Http\Requests\V1\UpdateRequirementRequest;
use App\Http\Resources\V1\RequirementResource;
use App\Models\Requirement;
use App\Models\Requirementdetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequirementController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        if ($user->role === "admin" || $user->role === "sadmin") {
            $query = Requirement::where('company_id', $user->company_id)
                ->get();
        } else {
            $query = Requirement::where('company_id', $user->company_id)
                ->where('user_id', $user->user_id)
                ->get();
        }
        return RequirementResource::collection($query)
            ->additional([
                'msg' => 'Listado satisfactorio',
                'title' => 'Requerimiento',
                'Error' => 0,
            ]);
    }

    public function store(StoreRequirementRequest $request)
    {
        $newRequirement = Requirement::create($request->validated());
        foreach ($request->items as $item) {
            Requirementdetail::create([
                'requirement_id' => $newRequirement->id,
                'product_id' => $item["product_id"],
                'productvariant_id' => $item["productvariant_id"],
                'unity_id' => $item['unity_id'],
                'nonexistent' => $item['nonexistent'],
                'detail' => $item['detail'],
                'quantity' => $item['quantity'],
            ]);
        }
        return RequirementResource::make($newRequirement)
            ->additional([
                'msg' => 'Registro Creado Correctamente',
                'title' => 'Requerimiento',
                'Error' => 0,
            ]);
    }
    public function show(Requirement $requirement)
    {
        return RequirementResource::make($requirement);
    }
    public function update(UpdateRequirementRequest $request, Requirement $requirement)
    {
        $requirement->update($request->all());
        return RequirementResource::make($requirement)
            ->additional([
                'msg' => 'Registro Actualizado Correctamente',
                'title' => 'Requerimiento',
                'Error' => 0,
            ]);
    }
    public function destroy(Requirement $requirement)
    {
        $requirement->delete();
        return RequirementResource::make($requirement)
            ->additional([
                'msg' => 'Registro Eliminado',
                'title' => 'Requerimiento',
                'Error' => 0,
            ]);
    }
}
