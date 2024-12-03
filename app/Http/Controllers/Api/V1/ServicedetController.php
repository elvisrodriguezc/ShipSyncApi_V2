<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\UpdateServicedetailRequest;
use App\Http\Resources\V1\ServicedetailResource;
use App\Models\Servicedetail;
use App\Models\Servicedetast;
use App\Models\Servicedetdoc;
use App\Models\Servicedetspent;
use App\Models\Servicedettip;
use App\Models\Servicedettipdet;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class ServicedetController extends Controller
{
    public function index()
    {
        $data = QueryBuilder::for(Servicedetail::class)
            ->get();
        return ServicedetailResource::collection($data)
            ->additional([
                'msg' => 'Listado correcto',
                'title' => 'Servicios',
                'Error' => 0,
            ]);
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Servicedetail $servicedetail, $id)
    {
        $servicedetail = Servicedetail::findOrFail($id);
        return ServicedetailResource::make($servicedetail)
            ->additional([
                'msg' => 'Visualizar el Registro',
                'title' => 'Servicio',
                'Error' => 0,
            ]);
    }


    public function update(UpdateServicedetailRequest $request, $id)
    {
        // Buscar el Servicedetail por ID
        $servicedetail = Servicedetail::findOrFail($id);

        // Actualizar los datos validados
        $servicedetail->update($request->validated());

        foreach ($request->personal as $persona) {
            if ($persona['status'] === 101) {
                // Crear una instancia de Servicedetast
                Servicedetast::create([
                    'servicedetail_id' => $servicedetail->id,
                    'user_id' => $persona['user']['id'],
                ]);
            }
            if ($persona['status'] === 100) {
                // Actualizar el estado a 0
                // Suponiendo que el modelo Persona tiene un método estático para actualizar
                Servicedetast::where('id', $persona['id'])
                    ->update(['status' => 0]);
            }
        }

        foreach ($request->adicionales as $adicional) {
            if ($adicional['status'] === 101) {
                // Crear una instancia de Servicedettip
                $servicedettip = Servicedettip::create([
                    'servicedetail_id' => $servicedetail->id,
                    'typevalue_id' => $adicional['typevalue_id'], //razón
                    'note' => $adicional['note'],
                ]);

                foreach ($adicional['detalle'] as $item) {
                    // Crear una instancia de Servicedettipdet
                    Servicedettipdet::create([
                        'servicedettip_id' => $servicedettip->id,
                        'user_id' => $item['usuario']['id'],
                        'amount' => $item['amount'],
                    ]);
                }
            }
        }

        foreach ($request->documentos as $documento) {
            if ($documento['status'] === 101) {
                $servicedetdoc = Servicedetdoc::create([
                    'servicedetail_id' => $servicedetail->id,
                    'typevalue_id' => $documento['tipoDocId'],
                    'serie' => $documento['serie'],
                    'number' => $documento['number'],
                    'ubigeodistrito_id' => $documento['distrito_id'],
                    'note' => $documento['note']
                ]);
            }
        }

        foreach ($request->spents as $gasto) {
            if ($gasto['status'] === 101) {
                $servicedetspent = Servicedetspent::create([
                    'servicedetail_id' => $servicedetail->id,
                    'ruc' => $gasto['ruc'],
                    'serie' => $gasto['serie'],
                    'number' => $gasto['number'],
                    'amount' => $gasto['amount'],
                    'detail' => $gasto['detail'],
                    'typecpe_id' => $gasto['tipecpe_id'],
                ]);
            }
        }

        return ServicedetailResource::make($servicedetail)
            ->additional([
                'msg' => 'Registro Actualizado Correctamente',
                'title' => 'Servicio',
                'Error' => 0,
            ]);
    }


    public function destroy(Servicedetail $servicedetail)
    {
        //
    }
}
