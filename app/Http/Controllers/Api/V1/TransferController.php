<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreTransferRequest;
use App\Http\Requests\V1\UpdateTransferRequest;
use App\Http\Resources\V1\TransferResource;
use App\Models\Transfer;
use App\Models\Transferdetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $query = Transfer::where('company_id', $user->company_id)
            ->get();

        return TransferResource::collection($query)
            ->additional([
                'msg' => 'Listado correcto',
                'title' => 'Transferencias',
                'Error' => 0,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTransferRequest $request)
    {
        $formData = $request->validated();
        $transfer = Transfer::create($formData);
        foreach ($request->items as $item) {
            Transferdetail::create([
                'transfer_id' => $transfer->id,
                'product_id' => $item["product_id"],
                'unity_id' => $item['unity_id'],
                'quantity' => $item['quantity'],
            ]);
        }
        return TransferResource::make($transfer)
            ->additional([
                'msg' => 'Registro Creado Correctamente',
                'title' => 'Transferencias',
                'Error' => 0,
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Transfer $transfer)
    {
        return TransferResource::make($transfer)
            ->additional([
                'msg' => 'Registro Actual',
                'title' => 'Transferencias',
                'Error' => 0,
            ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTransferRequest $request, Transfer $transfer)
    {
        $transfer->update($request->validated());
        return TransferResource::make($transfer)
            ->additional([
                'msg' => 'Registro Actualizado Correctamente',
                'title' => 'Transferencias',
                'Error' => 0,
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transfer $transfer)
    {
        $transfer->delete();
        return TransferResource::make($transfer)
            ->additional([
                'msg' => 'Registro Eliminado',
                'title' => 'Transferencias',
                'Error' => 0,
            ]);
    }
}
