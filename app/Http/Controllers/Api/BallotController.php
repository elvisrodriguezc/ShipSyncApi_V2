<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBallotRequest;
use App\Http\Resources\BallotResource;
use App\Models\Ballot;
use Illuminate\Http\Request;

class BallotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $data = Ballot::where('company_id', auth()->user()->company_id)->get();
        if ($request->type == 'results') {
            $data = Ballot::where('company_id', auth()->user()->company_id)
                ->selectRaw('candidate_id, COUNT(*) as cantidad')
                ->groupBy('candidate_id')
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->candidate_id,
                        'candidate_id' => $item->candidate_id,
                        'last_name' => $item->candidate->last_name,
                        'first_name' => $item->candidate->first_name,
                        'priority' => $item->candidate->priority,
                        'img' => $item->candidate->img,
                        'cantidad' => (int)$item->cantidad,
                    ];
                });
            return response()->json(['data' => $data]);
        }
        return BallotResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBallotRequest $request)
    {
        $ballot = Ballot::where('company_id', auth()->user()->company_id)
            ->where('user_id', $request->input('user_id'))
            ->where('status', 1)
            ->first();
        if (!$ballot) {
            $formData = $request->validated();
            $formData['company_id'] = auth()->user()->company_id;
            $ballot = Ballot::create($formData);
            $ballot->error = [
                'message' => 'Su voto ha sido registrado correctamente',
                'error' => 0
            ];
        } else {
            $ballot->error = [
                'message' => 'Usted ya ha votado',
                'error' => 1
            ];
        }
        return BallotResource::make($ballot);
    }

    /**
     * Display the specified resource.
     */
    public function show(Ballot $ballot)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ballot $ballot)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ballot $ballot)
    {
        //
    }
}
