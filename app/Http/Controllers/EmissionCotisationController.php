<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmissionCotisationRequest;
use App\Http\Requests\UpdateEmissionCotisationRequest;
use App\Models\EmissionCotisation;
use Illuminate\Http\JsonResponse;

class EmissionCotisationController extends Controller
{
    public function index(): JsonResponse
    {
        $emissions = EmissionCotisation::query()
            ->with(['mutuelle', 'adherent', 'encaissements'])
            ->orderByDesc('date_emission')
            ->get();

        return response()->json($emissions);
    }

    public function store(StoreEmissionCotisationRequest $request): JsonResponse
    {
        $emission = EmissionCotisation::query()->create($request->validated());
        $emission->load(['mutuelle', 'adherent', 'encaissements']);

        return response()->json($emission, 201);
    }

    public function show(EmissionCotisation $emissionCotisation): JsonResponse
    {
        $emissionCotisation->load(['mutuelle', 'adherent', 'encaissements']);

        return response()->json($emissionCotisation);
    }

    public function update(UpdateEmissionCotisationRequest $request, EmissionCotisation $emissionCotisation): JsonResponse
    {
        $emissionCotisation->update($request->validated());
        $emissionCotisation->load(['mutuelle', 'adherent', 'encaissements']);

        return response()->json($emissionCotisation);
    }

    public function destroy(EmissionCotisation $emissionCotisation): JsonResponse
    {
        $emissionCotisation->delete();

        return response()->json(null, 204);
    }
}
