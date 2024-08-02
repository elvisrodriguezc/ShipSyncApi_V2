<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreTransferdetailRequest;
use App\Http\Requests\V1\UpdateTransferdetailRequest;
use App\Http\Resources\V1\TransferdetailResource;
use App\Models\Transferdetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransferdetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $query = Transferdetail::get();

        return TransferdetailResource::collection($query)
            ->additional([
                'msg' => 'Listado correcto',
                'title' => 'Transferencias entre almacenes items',
                'Error' => 0,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTransferdetailRequest $request)
    {
        $formData = $request->validated();
        $transferdetail = Transferdetail::create($formData);
        return TransferdetailResource::make($transferdetail)
            ->additional([
                'msg' => 'Registro Creado Correctamente',
                'title' => 'Categorias',
                'Error' => 0,
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Transferdetail $transferdetail)
    {
        return TransferdetailResource::make($transferdetail);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTransferdetailRequest $request, Transferdetail $transferdetail)
    {
        $transferdetail->update($request->validated());
        return TransferdetailResource::make($transferdetail)
            ->additional([
                'msg' => 'Registro Actualizado Correctamente',
                'title' => 'Categorias',
                'Error' => 0,
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transferdetail $transferdetail)
    {
        $transferdetail->delete();
        return TransferdetailResource::make($transferdetail)
            ->additional([
                'msg' => 'Registro Eliminado',
                'title' => 'Categorias',
                'Error' => 0,
            ]);
    }
}
