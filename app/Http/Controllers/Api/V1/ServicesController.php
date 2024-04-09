<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreServicesRequest;
use App\Http\Resources\V1\ServicesResource;
use App\Models\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $data = QueryBuilder::for(Services::class)
            ->where('company_id', $user->company_id)
            ->get();

        return ServicesResource::collection($data)
            ->additional([
                'msg' => 'Listado correcto',
                'title' => 'Entidades',
                'Error' => 0,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServicesRequest $request)
    {
        $formData = $request->validated();
        $data = Services::create($formData);
        return ServicesResource::make($data)
            ->additional([
                'msg' => 'Registro Creado Correctamente',
                'title' => 'Servicios',
                'Error' => 0,
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Services $services)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Services $services)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Services $services)
    {
        //
    }
}
