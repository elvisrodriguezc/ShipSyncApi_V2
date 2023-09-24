<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Table;
use Illuminate\Http\Request;

use App\Http\Requests\V1\StoreTableRequest;
use App\Http\Requests\V1\UpdateTableRequest;
use App\Http\Resources\V1\TableResource;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;

class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $data = QueryBuilder::for(Table::class)
            ->allowedFilters(['text'])
            ->defaultSort('-created_at')
            ->allowedSorts(['text'])
            ->where('company_id', $user->company_id)
            ->get();

        return TableResource::collection($data)
            ->additional([
                'msg' => 'Listado correcto',
                'title' => 'Mesas',
                'Error' => 0,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTableRequest $request)
    {
        $user = Auth::user();
        $formData = $request->validated();
        $formData['company_id'] = $user->company_id; // Add the company_id field with user company
        $data = Table::create($formData);
        return TableResource::make($data)
            ->additional([
                'msg' => 'Registro Creado Correctamente',
                'title' => 'Mesas',
                'Error' => 0,
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Table $tables)
    {
        return TableResource::make($tables);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTableRequest $request, Table $category)
    {
        $category->update($request->validated());
        return TableResource::make($category)
            ->additional([
                'msg' => 'Registro Actualizado Correctamente',
                'title' => 'Mesas',
                'Error' => 0,
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Table $category)
    {
        $category->delete();
        return TableResource::make($category)
            ->additional([
                'msg' => 'Registro Eliminado',
                'title' => 'Mesas',
                'Error' => 0,
            ]);
    }
}
