<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePrestataireRequest;
use App\Http\Requests\UpdatePrestataireRequest;
use App\Models\Prestataire;
use Illuminate\Http\JsonResponse;

class PrestataireController extends Controller
{
    /**
     * Display a listing of the prestataires.
     */
    public function index(): JsonResponse
    {
        $prestataires = Prestataire::query()
            ->with(['department.region', 'classification'])
            ->orderBy('denomination')
            ->get();

        return response()->json($prestataires);
    }

    /**
     * Store a newly created prestataire in storage.
     */
    public function store(StorePrestataireRequest $request): JsonResponse
    {
        $prestataire = Prestataire::query()->create($request->validated());
        $prestataire->load(['department.region', 'classification']);

        return response()->json($prestataire, 201);
    }

    /**
     * Display the specified prestataire.
     */
    public function show(Prestataire $prestataire): JsonResponse
    {
        $prestataire->load(['department.region', 'classification']);

        return response()->json($prestataire);
    }

    /**
     * Update the specified prestataire in storage.
     */
    public function update(UpdatePrestataireRequest $request, Prestataire $prestataire): JsonResponse
    {
        $prestataire->update($request->validated());
        $prestataire->load(['department.region', 'classification']);

        return response()->json($prestataire);
    }

    /**
     * Remove the specified prestataire from storage.
     */
    public function destroy(Prestataire $prestataire): JsonResponse
    {
        $prestataire->delete();

        return response()->json(null, 204);
    }
}

