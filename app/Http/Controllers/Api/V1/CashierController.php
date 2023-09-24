<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Cashier;
use App\Http\Requests\V1\StoreCashierRequest;
use App\Http\Requests\V1\UpdateCashierRequest;
use App\Http\Resources\V1\CashierResource;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;

class CashierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $data = QueryBuilder::for(Cashier::class)
            ->allowedFilters(['text'])
            ->defaultSort('-created_at')
            ->allowedSorts(['text'])
            ->where('company_id', $user->company_id)
            ->get();

        return CashierResource::collection($data)
            ->additional([
                'msg' => 'Listado correcto',
                'title' => 'Caja',
                'Error' => 0,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCashierRequest $request)
    {
        $user = Auth::user();
        $formData = $request->validated();
        $formData['company_id'] = $user->company_id; // Add the company_id field with user company
        $formData['user_id'] = $user->id; // Add the company_id field with user company
        $data = Cashier::create($formData);
        return CashierResource::make($data)
            ->additional([
                'msg' => 'Registro Creado Correctamente',
                'title' => 'Caja',
                'Error' => 0,
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Cashier $cashier)
    {
        return CashierResource::make($cashier);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCashierRequest $request, Cashier $cashier)
    {
        $cashier->update($request->validated());
        return CashierResource::make($cashier)
            ->additional([
                'msg' => 'Registro Actualizado Correctamente',
                'title' => 'Caja',
                'Error' => 0,
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cashier $cashier)
    {
        $cashier->delete();
        return CashierResource::make($cashier)
            ->additional([
                'msg' => 'Registro Eliminado',
                'title' => 'Caja',
                'Error' => 0,
            ]);
    }

    public function cashierSelectActive()
    {
        $user = Auth::user();

        try {
            $data = QueryBuilder::for(Cashier::class)
                ->where('company_id', $user->company_id)
                ->where('user_id', $user->id)
                ->where('status', 1)
                ->first();

            if ($data) {
                return CashierResource::make($data)
                    ->additional([
                        'msg' => 'Caja Abierta',
                        'Error' => 0,
                    ]);
            } else {
                return response()->json([
                    'msg' => 'No se encontró una caja abierta',
                    'Error' => 0,
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'msg' => 'Error en la búsqueda',
                'Error' => 1,
            ], 404);
        }
    }
}
