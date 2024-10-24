<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $categories = Category::paginate(10);

        if ($categories->isEmpty()) {
            return response()->json(["message" => 'No data']);
        }

        return response()->json($categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $validated['image'] = Storage::put('category', $validated['image']);
        
        Category::create($validated);

        return response()->json(['message' => 'Category created successfully'], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category): JsonResponse
    {
        return response()->json($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category): JsonResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            Storage::delete($category->image);
            $validated['image'] = Storage::put('category', $request->image);
        }

        $validated['image'] ??= $category->image;
    
        $category->update($validated);

        return response()->json(['message' => 'category updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category): Response
    {
        Storage::delete($category->image);

        $category->delete();

        return response()->noContent();
    }
}
