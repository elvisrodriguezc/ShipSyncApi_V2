<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\ServicedetastResource;
use App\Models\Servicedetast;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class ServicedetastController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = QueryBuilder::for(Servicedetast::class)
            ->get();

        return ServicedetastResource::collection($data)
            ->additional([
                'msg' => 'Listado correcto',
                'title' => 'Entidades',
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
    public function show(Servicedetast $servicedetast)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Servicedetast $servicedetast)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Servicedetast $servicedetast)
    {
        //
    }
}
