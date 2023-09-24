<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Paymethod;
use App\Http\Requests\V1\StorePaymethodRequest;
use App\Http\Requests\V1\UpdatePaymethodRequest;
use App\Http\Resources\V1\PaymethodResource;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;

class PaymethodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $data = QueryBuilder::for(Paymethod::class)
            ->allowedFilters(['name'])
            ->defaultSort('name')
            ->allowedSorts(['name'])
            ->where('company_id', $user->company_id)
            ->get();

        return PaymethodResource::collection($data)
            ->additional([
                'msg' => 'Listado correcto',
                'title' => 'Metodos de Pago',
                'Error' => 0,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePaymethodRequest $request)
    {
        $user = Auth::user();
        $formData = $request->validated();
        $formData['company_id'] = $user->company_id; // Add the company_id field with user company
        $data = Paymethod::create($formData);
        return PaymethodResource::make($data)
            ->additional([
                'msg' => 'Registro Creado Correctamente',
                'title' => 'Metodos de Pago',
                'Error' => 0,
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Paymethod $paymethod)
    {
        return PaymethodResource::make($paymethod);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePaymethodRequest $request, Paymethod $paymethod)
    {
        $paymethod->update($request->validated());
        return PaymethodResource::make($paymethod)
            ->additional([
                'msg' => 'Registro Actualizado Correctamente',
                'title' => 'Metodos de Pago',
                'Error' => 0,
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Paymethod $paymethod)
    {
        $paymethod->delete();
        return PaymethodResource::make($paymethod)
            ->additional([
                'msg' => 'Registro Eliminado',
                'title' => 'Metodos de Pago',
                'Error' => 0,
            ]);
    }
}
