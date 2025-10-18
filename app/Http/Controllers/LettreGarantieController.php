<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLettreGarantieRequest;
use App\Http\Requests\UpdateLettreGarantieRequest;
use App\Models\LettreGarantie;
use Illuminate\Http\JsonResponse;

class LettreGarantieController extends Controller
{
    public function index(): JsonResponse
    {
        $lettres = LettreGarantie::query()
            ->with(['mutuelle', 'prestataire', 'adherent', 'ayantDroit', 'lignes.prestationOfferteLigne'])
            ->orderByDesc('date_emission')
            ->get();

        return response()->json($lettres);
    }

    public function store(StoreLettreGarantieRequest $request): JsonResponse
    {
        $lettre = LettreGarantie::query()->create($request->validated());
        $lettre->load(['mutuelle', 'prestataire', 'adherent', 'ayantDroit', 'lignes.prestationOfferteLigne']);

        return response()->json($lettre, 201);
    }

    public function show(LettreGarantie $lettreGarantie): JsonResponse
    {
        $lettreGarantie->load(['mutuelle', 'prestataire', 'adherent', 'ayantDroit', 'lignes.prestationOfferteLigne']);

        return response()->json($lettreGarantie);
    }

    public function update(UpdateLettreGarantieRequest $request, LettreGarantie $lettreGarantie): JsonResponse
    {
        $lettreGarantie->update($request->validated());
        $lettreGarantie->load(['mutuelle', 'prestataire', 'adherent', 'ayantDroit', 'lignes.prestationOfferteLigne']);

        return response()->json($lettreGarantie);
    }

    public function destroy(LettreGarantie $lettreGarantie): JsonResponse
    {
        $lettreGarantie->delete();

        return response()->json(null, 204);
    }
}
