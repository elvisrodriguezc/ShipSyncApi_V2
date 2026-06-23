<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Help;

class HelpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Everyone (authenticated) can see help topics
        $helps = Help::orderBy('category')->orderBy('title')->get();
        return response()->json(['data' => $helps]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = $request->user();
        if ($user->role && !in_array($user->role->slug ?? $user->role->name, ['sadmin', 'pfadmin'])) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $help = Help::create([
            'title' => $request->title,
            'category' => $request->category,
            'content' => $request->content,
        ]);

        return response()->json(['data' => $help]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Help $help)
    {
        return response()->json(['data' => $help]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Help $help)
    {
        $user = $request->user();
        if ($user->role && !in_array($user->role->slug ?? $user->role->name, ['sadmin', 'pfadmin'])) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $help->update([
            'title' => $request->title,
            'category' => $request->category,
            'content' => $request->content,
        ]);

        return response()->json(['data' => $help]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Help $help)
    {
        $user = $request->user();
        if ($user->role && !in_array($user->role->slug ?? $user->role->name, ['sadmin', 'pfadmin'])) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        $help->delete();

        return response()->json(['message' => 'Tema de ayuda eliminado correctamente']);
    }
}
