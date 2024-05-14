<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\PayrollafpResource;
use App\Models\Payrollafp;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class PayrollafpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = QueryBuilder::for(Payrollafp::class)
            ->get();
        return PayrollafpResource::collection($data)
            ->additional([
                'msg' => 'Registro Creado Correctamente',
                'title' => 'AFP',
                'Error' => 0,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Payrollafp $payrollafp)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payrollafp $payrollafp)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payrollafp $payrollafp)
    {
        //
    }
}
