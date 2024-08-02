<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreServicedettipdetRequest;
use App\Http\Requests\V1\UpdateServicedettipdetRequest;
use App\Http\Resources\V1\ServicedettipdetResource;
use App\Models\Servicedettipdet;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class ServicedettipdetController extends Controller
{
    public function index()
    {
        $data = QueryBuilder::for(Servicedettipdet::class)
            ->get();
        return ServicedettipdetResource::collection($data)
            ->additional([
                'msg' => 'Registro Creado Correctamente',
                'title' => 'Detalle de Adicionales',
                'Error' => 0,
            ]);
    }
    public function store(StoreServicedettipdetRequest $request)
    {
        $data = Servicedettipdet::create($request->validated());
        return ServicedettipdetResource::make($data)
            ->additional([
                'msg' => 'Registro Creado Correctamente',
                'title' => 'Detalle de Adicionales',
                'Error' => 0,
            ]);
    }
    public function show(Servicedettipdet $servicedettipdet)
    {
        return ServicedettipdetResource::make($servicedettipdet);
    }

    public function update(UpdateServicedettipdetRequest $request, Servicedettipdet $servicedettipdet)
    {
        $servicedettipdet->update($request->validated());
        return Servicedettipdet::make($servicedettipdet)
            ->additional([
                'msg' => 'Registro Actualizado Correctamente',
                'title' => 'Metodos de Pago',
                'Error' => 0,
            ]);
    }

    public function destroy(Servicedettipdet $servicedettipdet)
    {
        $servicedettipdet->delete();
        return ServicedettipdetResource::make($servicedettipdet)
            ->additional([
                'msg' => 'Registro Eliminado',
                'title' => 'Detalle de Adicionales',
                'Error' => 0,
            ]);
    }
}
