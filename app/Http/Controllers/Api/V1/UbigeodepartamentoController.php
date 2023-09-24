<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Ubigeodepartamento;
use App\Http\Resources\V1\UbigeodepartamentoResource;
use Spatie\QueryBuilder\QueryBuilder;

class UbigeodepartamentoController extends Controller
{
    public function index()
    {
        $ubigeodepartamento = QueryBuilder::for(Ubigeodepartamento::class)
            ->allowedFilters(['name'])
            ->defaultSort('name')
            ->allowedSorts(['name'])
            ->get();

        return UbigeodepartamentoResource::collection($ubigeodepartamento)
            ->additional([
                'msg' => 'Listado correcto',
                'title' => 'Departamentos',
                'Error' => 0,
            ]);
    }
    public function show(Ubigeodepartamento $ubigeodepartamento)
    {
        return UbigeodepartamentoResource::make($ubigeodepartamento);
    }
}
