<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTypeRequest;
use App\Http\Requests\UpdateTypeRequest;
use App\Http\Resources\TypeResource;
use App\Models\Type;
use Illuminate\Database\QueryException;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $types = Type::where('company_id', $user->company_id)
            ->get();
        return TypeResource::collection($types);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTypeRequest $request)
    {
        $data = $request->validated();
        $data['company_id'] = auth()->user()->company_id;
        $type = Type::create($data);
        return TypeResource::make($type);
    }

    /**
     * Display the specified resource.
     */
    public function show(Type $type)
    {
        return TypeResource::make($type);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTypeRequest $request, Type $type)
    {
        $data = $request->validated();
        $type->update($data);
        return TypeResource::make($type);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Type $type)
    {
        try {
            $type->delete();
            return TypeResource::make($type)
                ->additional([
                    'message' => 'Type deleted successfully',
                    'error' => 0
                ]);
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1] ?? null;
            if ($errorCode == 1451) { // MySQL foreign key constraint error
                return response()->json([
                    'message' => 'This type cannot be deleted because it is in use.',
                    'error' => 1
                ], 423); // 423 Locked
            }

            return response()->json([
                'message' => 'An error occurred while deleting the type.',
                'error' => 1
            ], 500);
        }
    }
}
