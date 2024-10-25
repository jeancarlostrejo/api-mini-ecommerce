<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLocationRequest;
use App\Models\Location;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LocationController extends Controller
{
    public function index()
    {
        $locations = auth()->user()->locations->load('user:id,name,email');

        if($locations->isEmpty()) {
            return response()->json(['message' => 'No locations found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json(["data"=> $locations]);
    }


    public function store(StoreLocationRequest $request): JsonResponse
    {
        auth()->user()->locations()->create($request->validated());

        return response()->json(['message' => 'Location created successfully'], Response::HTTP_CREATED);
    }

    public function update(StoreLocationRequest $request, Location $location): JsonResponse
    {
        $this->authorize('update', $location);

        $location->update($request->validated());

        return response()->json(['message' => 'Location updated successfully']);
    }

    public function destroy(Location $location): Response
    {
        $this->authorize('delete', $location);

        $location->delete();

        return response()->noContent();
    }
}
