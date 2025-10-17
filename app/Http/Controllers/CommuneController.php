<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommuneRequest;
use App\Http\Requests\UpdateCommuneRequest;
use App\Models\Commune;
use Illuminate\Http\JsonResponse;

class CommuneController extends Controller
{
    /**
     * Display a listing of the communes.
     */
    public function index(): JsonResponse
    {
        $communes = Commune::query()
            ->with('department.region')
            ->orderBy('name')
            ->get();

        return response()->json($communes);
    }

    /**
     * Store a newly created commune in storage.
     */
    public function store(StoreCommuneRequest $request): JsonResponse
    {
        $commune = Commune::query()->create($request->validated());
        $commune->load('department.region');

        return response()->json($commune, 201);
    }

    /**
     * Display the specified commune.
     */
    public function show(Commune $commune): JsonResponse
    {
        $commune->load('department.region');

        return response()->json($commune);
    }

    /**
     * Update the specified commune in storage.
     */
    public function update(UpdateCommuneRequest $request, Commune $commune): JsonResponse
    {
        $commune->update($request->validated());
        $commune->load('department.region');

        return response()->json($commune);
    }

    /**
     * Remove the specified commune from storage.
     */
    public function destroy(Commune $commune): JsonResponse
    {
        $commune->delete();

        return response()->json(null, 204);
    }
}

