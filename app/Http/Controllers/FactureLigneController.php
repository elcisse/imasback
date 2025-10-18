<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFactureLigneRequest;
use App\Http\Requests\UpdateFactureLigneRequest;
use App\Models\FactureLigne;
use Illuminate\Http\JsonResponse;

class FactureLigneController extends Controller
{
    public function index(): JsonResponse
    {
        $lignes = FactureLigne::query()
            ->with(['facture.mutuelle', 'facture.prestataire'])
            ->orderByDesc('created_at')
            ->get();

        return response()->json($lignes);
    }

    public function store(StoreFactureLigneRequest $request): JsonResponse
    {
        $ligne = FactureLigne::query()->create($request->validated());
        $ligne->load(['facture.mutuelle', 'facture.prestataire']);

        return response()->json($ligne, 201);
    }

    public function show(FactureLigne $factureLigne): JsonResponse
    {
        $factureLigne->load(['facture.mutuelle', 'facture.prestataire']);

        return response()->json($factureLigne);
    }

    public function update(UpdateFactureLigneRequest $request, FactureLigne $factureLigne): JsonResponse
    {
        $factureLigne->update($request->validated());
        $factureLigne->load(['facture.mutuelle', 'facture.prestataire']);

        return response()->json($factureLigne);
    }

    public function destroy(FactureLigne $factureLigne): JsonResponse
    {
        $factureLigne->delete();

        return response()->json(null, 204);
    }
}
