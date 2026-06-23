<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Devuelve el listado de categorías de la empresa del usuario autenticado.
     */
    public function index()
    {
        $user = auth()->user();
        $data = Category::where('company_id', $user->company_id)
            ->orderBy('name')
            ->get();
        return CategoryResource::collection($data);
    }

    /**
     * Crea una nueva categoría.
     */
    public function store(StoreCategoryRequest $request)
    {
        $user = auth()->user();
        $request->validated();
        $request->merge([
            'company_id' => $user->company_id,
            'slug'       => Str::slug($request->name),
            'status'     => true,
        ]);
        $data = Category::create($request->all());
        return CategoryResource::make($data);
    }

    /**
     * Muestra una categoría específica.
     */
    public function show($id)
    {
        $category = Category::where('company_id', auth()->user()->company_id)->findOrFail($id);
        return CategoryResource::make($category);
    }

    /**
     * Actualiza una categoría existente.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'status'      => 'nullable|boolean',
        ]);

        $category = Category::where('company_id', auth()->user()->company_id)->findOrFail($id);
        $category->update([
            'name'        => $request->name,
            'slug'        => Str::slug($request->name),
            'description' => $request->description,
            'status'      => $request->has('status') ? $request->status : $category->status,
        ]);

        return CategoryResource::make($category->fresh());
    }

    /**
     * Elimina una categoría.
     */
    public function destroy($id)
    {
        $category = Category::where('company_id', auth()->user()->company_id)->findOrFail($id);
        $category->delete();
        return response()->json([
            'id'      => $category->id,
            'message' => 'Categoría eliminada correctamente.',
        ]);
    }
}
