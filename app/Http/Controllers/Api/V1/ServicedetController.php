<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\UpdateServicedetailRequest;
use App\Http\Resources\V1\ServicedetailResource;
use App\Models\Servicedetail;
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

        foreach ($request->adicionales as $adicional) {
            if ($adicional['status'] === 200) {
                // Crear una instancia de Servicedettip
                $servicedettip = Servicedettip::create([
                    'servicedetail_id' => $servicedetail->id,
                    'typevalue_id' => $adicional['typevalue_id'],
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
            if ($documento['status'] === 200) {
                $servicedetdoc = Servicedetdoc::create([
                    'servicedetail_id' => $servicedetail->id,
                    'tipevalue_id' => $documento['documentoTipo']['id'],
                    'serie' => $documento['serie'],
                    'number' => $documento['number'],
                    'ubigeodistrito_id' => $documento['distrito']['id'],
                    'note' => $documento['note']
                ]);
            }
        }

        foreach ($request->spents as $gasto) {
            if ($gasto['status'] === 200) {
                $servicedetspent = Servicedetspent::create([
                    'servicedetail_id' => $servicedetail->id,
                    'ruc' => $gasto['ruc'],
                    'serie' => $gasto['serie'],
                    'number' => $gasto['number'],
                    'amount' => $gasto['amount'],
                    'detail' => $gasto['detail'],
                    'typecpe_id' => $gasto['tipoCPE']['id'],
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
