<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\CompanyResource;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyCompleteController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Company $company)
    {
        // $company->status = $request->status;
        $company->status = 5; // the five number means its completed
        $company->save();
        return CompanyResource::make($company)
            ->additional([
                'msg' => 'Registro ' . $company->id . ' Completado',
                'title' => 'Compañias',
                'Error' => 0,
            ]);
    }
}
