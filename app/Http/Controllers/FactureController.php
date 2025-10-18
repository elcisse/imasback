<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFactureRequest;
use App\Http\Requests\UpdateFactureRequest;
use App\Models\Facture;
use Illuminate\Http\JsonResponse;

class FactureController extends Controller
{
    public function index(): JsonResponse
    {
        $factures = Facture::query()
            ->with(['mutuelle', 'prestataire', 'lignes'])
            ->orderByDesc('date_facture')
            ->get();

        return response()->json($factures);
    }

    public function store(StoreFactureRequest $request): JsonResponse
    {
        $facture = Facture::query()->create($request->validated());
        $facture->load(['mutuelle', 'prestataire', 'lignes']);

        return response()->json($facture, 201);
    }

    public function show(Facture $facture): JsonResponse
    {
        $facture->load(['mutuelle', 'prestataire', 'lignes']);

        return response()->json($facture);
    }

    public function update(UpdateFactureRequest $request, Facture $facture): JsonResponse
    {
        $facture->update($request->validated());
        $facture->load(['mutuelle', 'prestataire', 'lignes']);

        return response()->json($facture);
    }

    public function destroy(Facture $facture): JsonResponse
    {
        $facture->delete();

        return response()->json(null, 204);
    }
}
