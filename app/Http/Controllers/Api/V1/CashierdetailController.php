<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Cashierdetail;
use App\Http\Requests\V1\StoreCashierdetailRequest;
use App\Http\Requests\V1\UpdateCashierdetailRequest;
use App\Http\Resources\V1\CashierdetailResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;

class CashierdetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->cashier) {
            $user = Auth::user();
            $data = QueryBuilder::for(Cashierdetail::class)
                ->where('cashier_id', $request->cashier)
                ->get();
        } else {
            return $data = response()->json([
                "data" => "Ups, Houston, I don't know what do you need. Please especify the Cashier parameter and a value",
                "message" => "Error",
                "error" => 1
            ], 400);
        }
        return CashierdetailResource::collection($data)
            ->additional([
                'msg' => 'Listado correcto',
                'title' => 'Movimiento de Caja',
                'Error' => 0,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCashierdetailRequest $request)
    {
        $user = Auth::user();
        $formData = $request->validated();
        $formData['company_id'] = $user->company_id; // Add the company_id field with user company
        $data = Cashierdetail::create($formData);
        return CashierdetailResource::make($data)
            ->additional([
                'msg' => 'Registro Creado Correctamente',
                'title' => 'Movimiento de Caja',
                'Error' => 0,
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Cashierdetail $cashierdetail)
    {
        return CashierdetailResource::make($cashierdetail);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCashierdetailRequest $request, Cashierdetail $cashierdetail)
    {
        $cashierdetail->update($request->validated());
        return CashierdetailResource::make($cashierdetail)
            ->additional([
                'msg' => 'Registro Actualizado Correctamente',
                'title' => 'Movimiento de Caja',
                'Error' => 0,
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cashierdetail $cashierdetail)
    {
        $cashierdetail->delete();
        return CashierdetailResource::make($cashierdetail)
            ->additional([
                'msg' => 'Registro Eliminado',
                'title' => 'Movimiento de Caja',
                'Error' => 0,
            ]);
    }
}
