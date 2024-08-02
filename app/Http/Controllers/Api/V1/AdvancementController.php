<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreAdvancementRequest;
use App\Http\Requests\V1\UpdateAdvancementRequest;
use App\Http\Resources\V1\AdvancementResource;
use App\Models\Advancement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdvancementController extends Controller
{
    public function index()
    {
        $advancements = Advancement::query()
            ->where('company_id', Auth::user()->company_id)
            ->get();

        return AdvancementResource::collection($advancements)
            ->additional([
                'msg' => 'Listado correcto',
                'title' => 'Adelantos',
                'Error' => 0,
            ]);
    }

    public function store(StoreAdvancementRequest $request)
    {
        $formData = $request->validated();
        $formData['company_id'] = Auth::user()->company_id;
        $formData['manager_id'] = Auth::user()->id;

        $advancement = new Advancement($formData);

        $advancement->status = 1;
        $advancement->save();

        return AdvancementResource::make($advancement)
            ->additional([
                'msg' => 'Registro Creado Correctamente',
                'title' => 'Adelantos',
                'Error' => 0,
            ]);
    }

    public function show(Advancement $advancement)
    {
        return AdvancementResource::make($advancement);
    }

    public function update(UpdateAdvancementRequest $request, Advancement $advancement)
    {
        $formData = $request->validated();

        $advancement->update($formData);
        return AdvancementResource::make($advancement)
            ->additional([
                'msg' => 'Registro Actualizado Correctamente',
                'title' => 'Adelantos',
                'Error' => 0,
            ]);
    }

    public function destroy(Advancement $advancement)
    {
        $advancement->delete();
        return AdvancementResource::make($advancement)
            ->additional([
                'msg' => 'Registro Eliminado',
                'title' => 'Adelantos',
                'Error' => 0,
            ]);
    }
}
