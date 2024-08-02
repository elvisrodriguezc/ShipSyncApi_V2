<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreAdvancementdetRequest;
use App\Http\Requests\V1\UpdateAdvancementdetRequest;
use App\Http\Resources\V1\AdvancementdetResource;
use App\Models\Advancementdet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdvancementdetController extends Controller
{
    public function index()
    {
        $advancementdets = Advancementdet::query()
            ->get();

        return AdvancementdetResource::collection($advancementdets)
            ->additional([
                'msg' => 'Listado correcto',
                'title' => 'Cuotas de Pago',
                'Error' => 0,
            ]);
    }

    public function store(StoreAdvancementdetRequest $request)
    {
        $formData = $request->validated();
        $formData['manager_id'] = Auth::user()->id;

        $advancementdet = new Advancementdet($formData);

        $advancementdet->status = 1;
        $advancementdet->save();

        return AdvancementdetResource::make($advancementdet)
            ->additional([
                'msg' => 'Registro Creado Correctamente',
                'title' => 'Cuotas de Pago',
                'Error' => 0,
            ]);
    }

    public function show(Advancementdet $advancementdet)
    {
        return AdvancementdetResource::make($advancementdet);
    }

    public function update(UpdateAdvancementdetRequest $request, Advancementdet $advancementdet)
    {
        $formData = $request->validated();

        $advancementdet->update($formData);
        return AdvancementdetResource::make($advancementdet)
            ->additional([
                'msg' => 'Registro Actualizado Correctamente',
                'title' => 'Cuotas de Pago',
                'Error' => 0,
            ]);
    }

    public function destroy(Advancementdet $advancementdet)
    {
        $advancementdet->delete();
        return AdvancementdetResource::make($advancementdet)
            ->additional([
                'msg' => 'Registro Eliminado',
                'title' => 'Cuotas de Pago',
                'Error' => 0,
            ]);
    }
}
