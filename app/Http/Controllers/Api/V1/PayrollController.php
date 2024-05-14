<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StorePayrollRequest;
use App\Http\Resources\V1\PayrollResource;
use App\Models\Payroll;
use App\Models\PayrollUser;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class PayrollController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = QueryBuilder::for(Payroll::class)
            ->get();
        return PayrollResource::collection($data)
            ->additional([
                'msg' => 'Registro Creado Correctamente',
                'title' => 'Planillas',
                'Error' => 0,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePayrollRequest $request)
    {
        $data = Payroll::create($request->validated());
        for ($i = 0; $i < count($request->users); $i++) {
            $data1 = PayrollUser::create([
                'payroll_id' => $data->id,
                'user_id' => $request->users[$i],
            ]);
        };
        return PayrollResource::make($data)
            ->additional([
                'msg' => 'Registro Creado Correctamente',
                'title' => 'Planillas',
                'Error' => 0,
            ]);
    }

    /**
     * Display the specified resource.25
     */
    public function show(Payroll $payroll)
    {
        return PayrollResource::make($payroll);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payroll $payroll)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payroll $payroll)
    {
        //
    }
}
