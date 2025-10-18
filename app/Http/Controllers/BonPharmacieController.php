<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBonPharmacieRequest;
use App\Http\Requests\UpdateBonPharmacieRequest;
use App\Models\BonPharmacie;
use Illuminate\Http\JsonResponse;

class BonPharmacieController extends Controller
{
    public function index(): JsonResponse
    {
        $bons = BonPharmacie::query()
            ->with(['mutuelle', 'prestataire', 'adherent', 'ayantDroit', 'lignes.medicament'])
            ->orderByDesc('date_emission')
            ->get();

        return response()->json($bons);
    }

    public function store(StoreBonPharmacieRequest $request): JsonResponse
    {
        $bon = BonPharmacie::query()->create($request->validated());
        $bon->load(['mutuelle', 'prestataire', 'adherent', 'ayantDroit', 'lignes.medicament']);

        return response()->json($bon, 201);
    }

    public function show(BonPharmacie $bonPharmacie): JsonResponse
    {
        $bonPharmacie->load(['mutuelle', 'prestataire', 'adherent', 'ayantDroit', 'lignes.medicament']);

        return response()->json($bonPharmacie);
    }

    public function update(UpdateBonPharmacieRequest $request, BonPharmacie $bonPharmacie): JsonResponse
    {
        $bonPharmacie->update($request->validated());
        $bonPharmacie->load(['mutuelle', 'prestataire', 'adherent', 'ayantDroit', 'lignes.medicament']);

        return response()->json($bonPharmacie);
    }

    public function destroy(BonPharmacie $bonPharmacie): JsonResponse
    {
        $bonPharmacie->delete();

        return response()->json(null, 204);
    }
}
