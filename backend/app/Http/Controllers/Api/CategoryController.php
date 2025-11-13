<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('tasks')->get();
        return response()->json($categories);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'color' => 'nullable|string|max:7',
            'icon' => 'nullable|string|max:50',
        ]);

        $category = Category::create($request->all());

        return response()->json($category, 201);
    }

    public function show(Category $category)
    {
        return response()->json($category->load('tasks'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'string|max:255|unique:categories,name,' . $category->id,
            'color' => 'nullable|string|max:7',
            'icon' => 'nullable|string|max:50',
        ]);

        $category->update($request->all());

        return response()->json($category);
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json([
            'message' => 'Categoría eliminada correctamente',
        ]);
    }
}
