<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $products = Product::paginate(10);

        if ($products->isEmpty()) {
            return response()->json(['message' => 'No products found', "data" => []], 200);
        }

        return response()->json($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $validated['image'] = Storage::put('products', $request->file('image'));

        Product::create($validated);

        return response()->json(['message' => 'Product created successfully'], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product): JsonResponse
    {
        $product->load(['category', 'brand']);

        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product): JsonResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            Storage::delete($product->image);
            $validated['image'] = Storage::put('products', $request->file('image'));
        }

        $validated['image'] ??= $product->image;

        $product->update($validated);

        return response()->json(['message' => 'Product updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): Response
    {
        Storage::delete($product->image);

        $product->delete();

        return response()->noContent();
    }
}
