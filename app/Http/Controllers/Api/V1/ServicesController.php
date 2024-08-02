<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreServicesRequest;
use App\Http\Resources\V1\ServicesResource;
use App\Models\Servicedetail;
use App\Models\Servicedetast;
use App\Models\Services;
use GuzzleHttp\Psr7\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\QueryBuilder;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function saveprogram(StoreServicesRequest $request)
    {
        $formData = $request->validated();
        $service = Services::create($formData);

        // Iniciar una transacción
        DB::beginTransaction();

        try {
            foreach ($request->programaciones as $programacion) {
                $vehicle_id = $programacion['vehicle']['id'];
                $typevalue_id = $programacion['type']['id'];

                // Crear una instancia de Servicedetail
                $servicedetail = new Servicedetail([
                    'services_id' => $service->id,
                    'vehicle_id' => $vehicle_id,
                    'typevalue_id' => $typevalue_id,
                ]);
                $servicedetail->save();

                foreach ($programacion['personal'] as $persona) {
                    $servicedetast = new Servicedetast([
                        'servicedetail_id' => $servicedetail->id,
                        'user_id' => $persona['id'],
                    ]);
                    $servicedetast->save();
                }
            }

            // Confirmar la transacción
            DB::commit();

            return ServicesResource::make($service);
        } catch (\Exception $e) {
            // Revertir la transacción en caso de error
            DB::rollback();
            // Manejar el error según tus necesidades
            // Por ejemplo, puedes lanzar una excepción personalizada o registrar el error
            return response()->json(['error' => 'Error al guardar los datos'], 500);
        }
    }


    public function index(Request $request)
    {
        $user = Auth::user();
        if (!isset($request->startdate) || !isset($request->finishdate)) {
            return [
                "Message" => "Ingrese las variables",
                "data" => []
            ];
        }

        $data = QueryBuilder::for(Services::class)
            ->where('company_id', $user->company_id)
            ->where('status', 1)
            ->whereBetween('date', [$request->startdate, $request->finishdate])
            ->get();

        return ServicesResource::collection($data)
            ->additional([
                'msg' => 'Listado correcto',
                'title' => 'Programaciones',
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
    public function show(Services $myservices)
    {
        return ServicesResource::make($myservices);
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
