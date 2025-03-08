<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHeadquarterRequest;
use App\Http\Requests\UpdateHeadquarterRequest;
use App\Http\Resources\HeadquarterResource;
use App\Models\Headquarter;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class HeadquarterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $data = Headquarter::where('company_id', $user->company_id)
            ->orderBy('name')
            ->get();
        return HeadquarterResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHeadquarterRequest $request)
    {
        $data = $request->validated();
        $data['company_id'] = auth()->user()->company_id;
        $headquarter = Headquarter::create($data);
        return HeadquarterResource::make($headquarter);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $headquarter = Headquarter::find($id);
        return HeadquarterResource::make($headquarter);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHeadquarterRequest $request, $id)
    {
        $data = $request->validated();
        $headquarter = Headquarter::find($id);
        $headquarter->update($data);
        return HeadquarterResource::make($headquarter);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Headquarter $headquarter)
    {
        try {
            $headquarter->delete();
            return response()->json(['message' => 'Headquarter deleted'], 200);
        } catch (QueryException $e) {
            // Check if it's a foreign key constraint violation
            if ($e->getCode() == 23000) {
                return response()->json(['message' => 'Cannot delete headquarter because it is being used by other records'], 409);
            }
            return response()->json(['message' => 'Error deleting headquarter'], 500);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error deleting headquarter'], 500);
        }
    }
}
