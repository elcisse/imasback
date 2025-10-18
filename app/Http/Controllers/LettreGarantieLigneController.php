<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLettreGarantieLigneRequest;
use App\Http\Requests\UpdateLettreGarantieLigneRequest;
use App\Models\LettreGarantieLigne;
use Illuminate\Http\JsonResponse;

class LettreGarantieLigneController extends Controller
{
    public function index(): JsonResponse
    {
        $lignes = LettreGarantieLigne::query()
            ->with(['lettreGarantie', 'prestationOfferteLigne'])
            ->orderByDesc('created_at')
            ->get();

        return response()->json($lignes);
    }

    public function store(StoreLettreGarantieLigneRequest $request): JsonResponse
    {
        $ligne = LettreGarantieLigne::query()->create($request->validated());
        $ligne->load(['lettreGarantie', 'prestationOfferteLigne']);

        return response()->json($ligne, 201);
    }

    public function show(LettreGarantieLigne $lettreGarantieLigne): JsonResponse
    {
        $lettreGarantieLigne->load(['lettreGarantie', 'prestationOfferteLigne']);

        return response()->json($lettreGarantieLigne);
    }

    public function update(UpdateLettreGarantieLigneRequest $request, LettreGarantieLigne $lettreGarantieLigne): JsonResponse
    {
        $lettreGarantieLigne->update($request->validated());
        $lettreGarantieLigne->load(['lettreGarantie', 'prestationOfferteLigne']);

        return response()->json($lettreGarantieLigne);
    }

    public function destroy(LettreGarantieLigne $lettreGarantieLigne): JsonResponse
    {
        $lettreGarantieLigne->delete();

        return response()->json(null, 204);
    }
}
