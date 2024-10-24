<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use App\Models\Brand;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BrandController extends Controller
{
    public function index(): JsonResponse
    {
        $brands = Brand::paginate(10);

        if ($brands->isEmpty()) {
            return response()->json(["message" => 'No data']);
        }

        return response()->json(['data' => $brands]);
    }

    public function show(Brand $brand): JsonResponse
    {
        return response()->json($brand);
    }

    public function store(StoreBrandRequest $request): JsonResponse
    {
        Brand::create($request->validated());

        return response()->json(['message' => 'brand created successfully'], Response::HTTP_CREATED);
    }

    public function update(Brand $brand, UpdateBrandRequest $request): JsonResponse
    {
        $brand->update($request->validated());

        return response()->json(['message' => 'brand updated successfully']);
    }

    public function destroy(Brand $brand): Response
    {
        $brand->delete();

        return response()->noContent();
    }
}
