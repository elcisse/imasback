<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEncaissementCotisationRequest;
use App\Http\Requests\UpdateEncaissementCotisationRequest;
use App\Models\EncaissementCotisation;
use Illuminate\Http\JsonResponse;

class EncaissementCotisationController extends Controller
{
    public function index(): JsonResponse
    {
        $encaissements = EncaissementCotisation::query()
            ->with(['emission.mutuelle', 'emission.adherent'])
            ->orderByDesc('date_encaissement')
            ->get();

        return response()->json($encaissements);
    }

    public function store(StoreEncaissementCotisationRequest $request): JsonResponse
    {
        $encaissement = EncaissementCotisation::query()->create($request->validated());
        $encaissement->load(['emission.mutuelle', 'emission.adherent']);

        return response()->json($encaissement, 201);
    }

    public function show(EncaissementCotisation $encaissementCotisation): JsonResponse
    {
        $encaissementCotisation->load(['emission.mutuelle', 'emission.adherent']);

        return response()->json($encaissementCotisation);
    }

    public function update(UpdateEncaissementCotisationRequest $request, EncaissementCotisation $encaissementCotisation): JsonResponse
    {
        $encaissementCotisation->update($request->validated());
        $encaissementCotisation->load(['emission.mutuelle', 'emission.adherent']);

        return response()->json($encaissementCotisation);
    }

    public function destroy(EncaissementCotisation $encaissementCotisation): JsonResponse
    {
        $encaissementCotisation->delete();

        return response()->json(null, 204);
    }
}
