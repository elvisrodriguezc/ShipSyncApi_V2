<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Http\Requests\V1\StoreCurrencyRequest;
use App\Http\Requests\V1\UpdateCurrencyRequest;
use App\Http\Resources\V1\CurrencyResource;
use Spatie\QueryBuilder\QueryBuilder;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = QueryBuilder::for(Currency::class)
            ->allowedFilters(['name'])
            ->defaultSort('name')
            ->allowedSorts(['name'])
            ->get();
        return CurrencyResource::collection($data)
            ->additional([
                'msg' => 'Listado correcto',
                'title' => 'Monedas',
                'Error' => 0,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCurrencyRequest $request)
    {
        $currency = Currency::create($request->validated());
        return CurrencyResource::make($currency)
            ->additional([
                'msg' => 'Registro Creado Correctamente',
                'title' => 'Monedas',
                'Error' => 0,
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Currency $currency)
    {
        return CurrencyResource::make($currency);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCurrencyRequest $request, Currency $currency)
    {
        $currency->update($request->validated());
        return CurrencyResource::make($currency)
            ->additional([
                'msg' => 'Registro Actualizado Correctamente',
                'title' => 'Monedas',
                'Error' => 0,
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Currency $currency)
    {
        $currency->delete();
        return CurrencyResource::make($currency)
            ->additional([
                'msg' => 'Registro Eliminado',
                'title' => 'Monedas',
                'Error' => 0,
            ]);
    }
}
