<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StorePayrollRequest;
use App\Http\Resources\V1\PayrollUserResource;
use App\Models\PayrollUser;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class PayrollUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = QueryBuilder::for(PayrollUser::class)
            ->where('payroll_id', $request->payroll)
            ->get();

        return PayrollUserResource::collection($data)
            ->additional([
                'msg' => 'Registro Creado Correctamente',
                'title' => 'PlanillasUsuarios',
                'Error' => 0,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePayrollRequest $request)
    {
        $data = PayrollUser::create($request->validated());
        return PayrollUserResource::make($data)
            ->additional([
                'msg' => 'Registro Creado Correctamente',
                'title' => 'Usuarios de Planilla',
                'Error' => 0,
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(PayrollUser $payrollUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PayrollUser $payrollUser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PayrollUser $payrollUser)
    {
        //
    }
}
