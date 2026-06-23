<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBatchRequest;
use App\Http\Requests\UpdateBatchRequest;
use App\Http\Resources\BatchResource;
use App\Models\Batch;

class BatchController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $data = Batch::where('company_id', $user->company_id)->get();
        return BatchResource::collection($data);
    }

    public function store(StoreBatchRequest $request)
    {
        $user = auth()->user();
        $request->validated();
        $request->merge([
            'company_id' => $user->company_id,
        ]);
        $data = Batch::create($request->all());
        return BatchResource::make($data);
    }

    public function show($id_lote)
    {
        $batch = Batch::where('company_id', auth()->user()->company_id)->findOrFail($id_lote);
        return BatchResource::make($batch);
    }

    public function update(UpdateBatchRequest $request, $id_lote)
    {
        $request->validated();
        $batch = Batch::where('company_id', auth()->user()->company_id)->findOrFail($id_lote);
        $batch->update($request->all());
        return BatchResource::make($batch);
    }

    public function destroy($id_lote)
    {
        $batch = Batch::where('company_id', auth()->user()->company_id)->findOrFail($id_lote);
        $batch->delete();
        return BatchResource::make($batch)->additional([
            'message' => 'Batch deleted successfully',
        ]);
    }
}
