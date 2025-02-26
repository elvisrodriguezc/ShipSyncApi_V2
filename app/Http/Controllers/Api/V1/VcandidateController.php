<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreVcandidateRequest;
use App\Http\Resources\V1\VcandidateResource;
use App\Models\Vcandidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VcandidateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Vcandidate::get();
        return VcandidateResource::collection($data)
            ->additional([
                'msg' => 'Listado correcto',
                'title' => 'Candidato',
                'Error' => 0,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVcandidateRequest $request)
    {
        $user = Auth::user();
        $formData = $request->validated();
        $formData['company_id'] = $user->company_id; // Agregar el campo company_id con el valor de la Empresa del usuario
        $formData['user_id'] = $user->id; // Agregar el campo user_id con el valor del ID del usuario
        $data = new Vcandidate($formData);
        if ($request->hasFile('image')) {
            $path = $request->image->store('products', 'images');
            $data->image = $path; // Asignar la ruta de la imagen al campo image_url del producto
        }
        $data->save();
        return VcandidateResource::make($data)
            ->additional([
                'msg' => 'Guardado correctamente',
                'title' => 'Candidato',
                'Error' => 0,
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Vcandidate $vcandidate)
    {
        return VcandidateResource::make($vcandidate)
            ->additional([
                'msg' => 'Consulta correcta',
                'title' => 'Candidato',
                'Error' => 0,
            ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vcandidate $vcandidate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vcandidate $vcandidate)
    {
        //
    }
}
