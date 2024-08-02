<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreServicedettipRequest;
use App\Http\Resources\V1\ServicedettipResource;
use App\Models\Servicedettip;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class ServicedettipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = QueryBuilder::for(Servicedettip::class)
            // ->where('servicedetail_id', $request->servicedetail)
            ->get();

        return ServicedettipResource::collection($data)
            ->additional([
                'msg' => 'Listado correcto',
                'title' => 'Asignaciones Adicionales',
                'Error' => 0,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServicedettipRequest $request)
    {
        $formData = $request->validated();
        $data = Servicedettip::create($formData);
        return ServicedettipResource::make($data)
            ->additional([
                'msg' => 'Registro Creado Correctamente',
                'title' => 'Asignaciones Adicionales',
                'Error' => 0,
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Servicedettip $servicedettip)
    {
        return ServicedettipResource::make($servicedettip);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Servicedettip $servicedettip)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Servicedettip $servicedettip)
    {
        //
    }
}
