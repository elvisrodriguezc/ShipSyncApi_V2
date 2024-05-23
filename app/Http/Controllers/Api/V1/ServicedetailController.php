<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreServicedetailRequest;
use App\Http\Resources\V1\ServicedetailResource;
use App\Models\Servicedetail;
use App\Models\Servicedetast;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;

class ServicedetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        // $data = Servicedetast::find(1)->servicedetail_id; // Cambia el 1 por el ID del usuario deseado
        $serviceDetIds = Servicedetast::where('user_id', $user->id)->pluck('servicedetail_id')->toArray();

        $data = QueryBuilder::for(Servicedetail::class)
            ->whereIn('id', $serviceDetIds)
            ->get();

        return ServicedetailResource::collection($data)
            ->additional([
                'msg' => 'Listado correcto',
                'title' => 'Detalle de Servicios',
                'Error' => 0,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServicedetailRequest $request)
    {
        $user = Auth::user();
        $formData = $request->validated();
        $data = Servicedetail::create($formData);
        return ServicedetailResource::make($data)
            ->additional([
                'msg' => 'Registro Creado Correctamente',
                'title' => 'Entidades',
                'Error' => 0,
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Servicedetail $servicedetail)
    {
        dd($servicedetail);
        return ServicedetailResource::make($servicedetail);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Servicedetail $servicedetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Servicedetail $servicedetail)
    {
        //
    }
}
