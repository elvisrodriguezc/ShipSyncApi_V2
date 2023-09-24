<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Ubigeoprovincia;
use App\Http\Resources\V1\UbigeoprovinciaResource;
use Spatie\QueryBuilder\QueryBuilder;

class UbigeoprovinciaController extends Controller
{
    public function index()
    {
        $categories = QueryBuilder::for(Ubigeoprovincia::class)
            ->allowedFilters(['name'])
            ->defaultSort('name')
            ->allowedSorts(['name'])
            ->get();

        return UbigeoprovinciaResource::collection($categories)
            ->additional([
                'msg' => 'Listado correcto',
                'title' => 'Categorias',
                'Error' => 0,
            ]);
    }
    public function show(Ubigeoprovincia $ubigeoprovincia)
    {
        return UbigeoprovinciaResource::make($ubigeoprovincia);
    }
}
