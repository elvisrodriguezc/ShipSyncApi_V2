<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProgramationRequest;
use App\Http\Resources\ProgramationResource;
use App\Models\Programation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProgramationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $company_id = $user->company_id;
        $data = Programation::where('user_id', $company_id)->get();
        return ProgramationResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProgramationRequest $request)
    {
        $formData = $request->validated();
        $programation = Programation::create($formData);

        // Iniciar una transacción
        // DB::beginTransaction();

        // try {
        //     foreach ($request->programaciones as $programacion) {
        //         $vehicle_id = $programacion['vehicle']['id'];
        //         $typevalue_id = $programacion['type']['id'];

        // Crear una instancia de Servicedetail
        // $servicedetail = new Servicedetail([
        //     'services_id' => $service->id,
        //     'vehicle_id' => $vehicle_id,
        //     'typevalue_id' => $typevalue_id,
        // ]);
        // $servicedetail->save();

        // foreach ($programacion['personal'] as $persona) {
        //     $servicedetast = new Servicedetast([
        //         'servicedetail_id' => $servicedetail->id,
        //         'user_id' => $persona['id'],
        //     ]);
        //     $servicedetast->save();
        // }
        // }

        // Confirmar la transacción
        // DB::commit();

        return ProgramationResource::make($programation);
        // } catch (\Exception $e) {
        //     // Revertir la transacción en caso de error
        //     DB::rollback();
        //     // Manejar el error según tus necesidades
        //     // Por ejemplo, puedes lanzar una excepción personalizada o registrar el error
        //     return response()->json(['error' => 'Error al guardar los datos'], 500);
        // }
    }

    /**
     * Display the specified resource.
     */
    public function show(Programation $programation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Programation $programation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Programation $programation)
    {
        //
    }
}
