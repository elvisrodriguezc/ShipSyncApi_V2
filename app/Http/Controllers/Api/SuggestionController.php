<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Suggestion;
use App\Http\Resources\SuggestionResource;

class SuggestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        
        // Eager load the user relation
        $query = Suggestion::with('user');

        // Non-admins can only see their own suggestions
        if ($user->role && !in_array($user->role->slug ?? $user->role->name, ['sadmin', 'pfadmin'])) {
            $query->where('user_id', $user->id);
        }

        $suggestions = $query->orderBy('created_at', 'desc')->get();

        return SuggestionResource::collection($suggestions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $suggestion = Suggestion::create([
            'user_id' => $request->user()->id,
            'subject' => $request->subject,
            'description' => $request->description,
            'status' => 'pendiente',
        ]);

        return new SuggestionResource($suggestion->load('user'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Suggestion $suggestion)
    {
        return new SuggestionResource($suggestion->load('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Suggestion $suggestion)
    {
        // Only admins can update the status of a suggestion
        $user = $request->user();
        if ($user->role && !in_array($user->role->slug ?? $user->role->name, ['sadmin', 'pfadmin'])) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        $request->validate([
            'status' => 'required|string|in:pendiente,revisado,rechazado',
        ]);

        $suggestion->update([
            'status' => $request->status,
        ]);

        return new SuggestionResource($suggestion->load('user'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Suggestion $suggestion)
    {
        // Only admins can delete suggestions
        $user = $request->user();
        if ($user->role && !in_array($user->role->slug ?? $user->role->name, ['sadmin', 'pfadmin'])) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        $suggestion->delete();

        return response()->json(['message' => 'Sugerencia eliminada correctamente']);
    }
}
