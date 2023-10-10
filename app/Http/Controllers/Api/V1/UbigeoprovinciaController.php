<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Ubigeoprovincia;
use App\Http\Resources\V1\UbigeoprovinciaResource;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class UbigeoprovinciaController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->region) {
            return response()->json([
                'msg' => "I don't know what do you need, please sendme a Query Value region, and try again",
                'title' => 'Error',
                'Error' => 1,
            ]);
        }

        $categories = QueryBuilder::for(Ubigeoprovincia::class)
            ->allowedFilters(['name'])
            ->defaultSort('name')
            ->allowedSorts(['name'])
            ->where('ubigeodepartamento_id', $request->region)
            ->get();

        return UbigeoprovinciaResource::collection($categories)
            ->additional([
                'msg' => 'Listado correcto',
                'title' => 'Provincias',
                'Error' => 0,
            ]);
    }

    public function show(Ubigeoprovincia $ubigeoprovincia)
    {
        return UbigeoprovinciaResource::make($ubigeoprovincia);
    }
}
