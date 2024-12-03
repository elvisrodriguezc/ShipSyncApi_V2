<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreServicedetailRequest;
use App\Http\Requests\V1\UpdateServicedetailRequest;
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
    public function updateService(UpdateServicedetailRequest $request, Servicedetail $servicedetail)
    {
        $servicedetail->update($request->validated());
        // return ServicedetailResource::make($servicedetail)
        //     ->additional([
        //         'msg' => 'Registro Actualizado Correctamente',
        //         'title' => 'Servicedetail',
        //         'Error' => 0,
        //     ]);
        return "nada";
    }

    public function index(Request $request)
    {
        $user = $request->user ? (object)['id' => $request->user, 'role' => 'ayudante'] : Auth::user();

        $serviceDetIds = Servicedetast::where('user_id', $user->id)->pluck('servicedetail_id')->toArray();

        $data = Servicedetail::when(!in_array($user->role, ['admin', 'sadmin']), function ($query) use ($serviceDetIds) {
            return $query->whereIn('id', $serviceDetIds);
        })->get();

        return ServicedetailResource::collection($data)->additional([
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
    public function show($id)
    {
        $servicedetail = Servicedetail::findOrFail($id);
        return ServicedetailResource::make($servicedetail);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServicedetailRequest $request, Servicedetail $servicedetail)
    {
        $servicedetail->update($request->validated());
        return ServicedetailResource::make($servicedetail)
            ->additional([
                'msg' => 'Registro Actualizado Correctamente',
                'title' => 'Servicedetail',
                'Error' => 0,
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Servicedetail $servicedetail)
    {
        $servicedetail->delete();
        return ServicedetailResource::make($servicedetail)
            ->additional([
                'msg' => 'Registro Eliminado',
                'title' => 'Servicedetail',
                'Error' => 0,
            ]);
    }
}
