<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\UbigeodistritoResource;
use App\Models\Ubigeodistrito;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class UbigeodistritoController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->provincia) {
            return response()->json([
                'msg' => "I don't know what do you need, please sendme a Query Value provincia, and try again",
                'title' => 'Error',
                'Error' => 1,
            ]);
        }
        $data = QueryBuilder::for(Ubigeodistrito::class)
            ->allowedFilters(['text'])
            ->defaultSort('-created_at')
            ->allowedSorts(['text'])
            ->where('ubigeoprovincia_id', $request->provincia)
            ->get();

        return UbigeodistritoResource::collection($data)
            ->additional([
                'msg' => 'Listado correcto',
                'title' => 'Distritos',
                'Error' => 0,
            ]);
    }

    public function show(Ubigeodistrito $ubigeodistrito)
    {
        return UbigeodistritoResource::make($ubigeodistrito);
    }
}
