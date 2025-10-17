<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRegionRequest;
use App\Http\Requests\UpdateRegionRequest;
use App\Models\Region;
use Illuminate\Http\JsonResponse;

class RegionController extends Controller
{
    /**
     * Display a listing of the regions.
     */
    public function index(): JsonResponse
    {
        $regions = Region::query()
            ->withCount('departments')
            ->orderBy('region')
            ->get();

        return response()->json($regions);
    }

    /**
     * Store a newly created region in storage.
     */
    public function store(StoreRegionRequest $request): JsonResponse
    {
        $region = Region::query()->create($request->validated());

        return response()->json($region, 201);
    }

    /**
     * Display the specified region.
     */
    public function show(Region $region): JsonResponse
    {
        $region->load('departments');

        return response()->json($region);
    }

    /**
     * Update the specified region in storage.
     */
    public function update(UpdateRegionRequest $request, Region $region): JsonResponse
    {
        $region->update($request->validated());
        $region->load('departments');

        return response()->json($region);
    }

    /**
     * Remove the specified region from storage.
     */
    public function destroy(Region $region): JsonResponse
    {
        $region->delete();

        return response()->json(null, 204);
    }
}

