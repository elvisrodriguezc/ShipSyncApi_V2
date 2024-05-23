<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\IconResource;
use App\Models\Icon;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class IconController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = QueryBuilder::for(Icon::class)
            ->get();

        return IconResource::collection($data)
            ->additional([
                'msg' => 'Listado correcto',
                'title' => 'Font Awesonme Icons',
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
    public function show(Icon $icon)
    {
        return IconResource::make($icon);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Icon $icon)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Icon $icon)
    {
        //
    }
}
