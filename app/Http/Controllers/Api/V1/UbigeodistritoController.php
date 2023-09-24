<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\UbigeodistritoResource;
use App\Models\Ubigeodistrito;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class UbigeodistritoController extends Controller
{
    public function index()
    {
        $data = QueryBuilder::for(Ubigeodistrito::class)
            ->allowedFilters(['text'])
            ->defaultSort('-created_at')
            ->allowedSorts(['text'])
            ->get();

        return UbigeodistritoResource::collection($data)
            ->additional([
                'msg' => 'Listado correcto',
                'title' => 'Categorias',
                'Error' => 0,
            ]);
    }

    public function show(Ubigeodistrito $ubigeodistrito)
    {
        return UbigeodistritoResource::make($ubigeodistrito);
    }
}
