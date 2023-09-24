<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Company;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreCompanyRequest;
use App\Http\Requests\V1\UpdateCompanyRequest;
use App\Http\Resources\V1\CompanyResource;
use Spatie\QueryBuilder\QueryBuilder;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = QueryBuilder::for(Company::class)
            ->allowedFilters(['name', 'email'])
            ->defaultSort('-created_at')
            ->allowedSorts(['name', 'status'])
            ->get();
        return CompanyResource::collection($data)
            ->additional([
                'msg' => 'Listado correcto',
                'title' => 'Compañias',
                'Error' => 0,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompanyRequest $request)
    {
        $company = Company::create($request->validated());
        return CompanyResource::make($company)
            ->additional([
                'msg' => 'Registro Creado Correctamente',
                'title' => 'Compañias',
                'Error' => 0,
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        return CompanyResource::make($company);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompanyRequest $request, Company $company)
    {
        $company->update($request->validated());
        return CompanyResource::make($company)
            ->additional([
                'msg' => 'Registro Actualizado Correctamente',
                'title' => 'Compañias',
                'Error' => 0,
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        $company->delete();
        return CompanyResource::make($company)
            ->additional([
                'msg' => 'Registro Eliminado',
                'title' => 'Compañias',
                'Error' => 0,
            ]);
    }
}
