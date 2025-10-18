<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBonPharmacieLigneRequest;
use App\Http\Requests\UpdateBonPharmacieLigneRequest;
use App\Models\BonPharmacieLigne;
use Illuminate\Http\JsonResponse;

class BonPharmacieLigneController extends Controller
{
    public function index(): JsonResponse
    {
        $lignes = BonPharmacieLigne::query()
            ->with(['bonPharmacie', 'medicament'])
            ->orderByDesc('created_at')
            ->get();

        return response()->json($lignes);
    }

    public function store(StoreBonPharmacieLigneRequest $request): JsonResponse
    {
        $ligne = BonPharmacieLigne::query()->create($request->validated());
        $ligne->load(['bonPharmacie', 'medicament']);

        return response()->json($ligne, 201);
    }

    public function show(BonPharmacieLigne $bonPharmacieLigne): JsonResponse
    {
        $bonPharmacieLigne->load(['bonPharmacie', 'medicament']);

        return response()->json($bonPharmacieLigne);
    }

    public function update(UpdateBonPharmacieLigneRequest $request, BonPharmacieLigne $bonPharmacieLigne): JsonResponse
    {
        $bonPharmacieLigne->update($request->validated());
        $bonPharmacieLigne->load(['bonPharmacie', 'medicament']);

        return response()->json($bonPharmacieLigne);
    }

    public function destroy(BonPharmacieLigne $bonPharmacieLigne): JsonResponse
    {
        $bonPharmacieLigne->delete();

        return response()->json(null, 204);
    }
}
