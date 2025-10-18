<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreConventionStructureSanitaireRequest;
use App\Http\Requests\UpdateConventionStructureSanitaireRequest;
use App\Models\ConventionStructureSanitaire;
use App\Models\Prestataire;
use Illuminate\Http\JsonResponse;

class ConventionStructureSanitaireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $conventions = ConventionStructureSanitaire::query()
            ->with(['mutuelle', 'prestataire.department'])
            ->orderByDesc('date_effet')
            ->get();

        return response()->json($conventions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreConventionStructureSanitaireRequest $request): JsonResponse
    {
        $data = $request->validated();

        $prestataire = Prestataire::query()->findOrFail($data['prestataire_id']);
        if ($prestataire->type !== Prestataire::TYPE_STRUCTURE_SANITAIRE) {
            return response()->json([
                'message' => 'Le prestataire sélectionné n\'est pas une structure sanitaire.',
            ], 422);
        }

        $convention = ConventionStructureSanitaire::query()->create($data);
        $convention->load(['mutuelle', 'prestataire.department']);

        return response()->json($convention, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(ConventionStructureSanitaire $conventionStructureSanitaire): JsonResponse
    {
        $conventionStructureSanitaire->load(['mutuelle', 'prestataire.department']);

        return response()->json($conventionStructureSanitaire);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateConventionStructureSanitaireRequest $request, ConventionStructureSanitaire $conventionStructureSanitaire): JsonResponse
    {
        $data = $request->validated();

        if (array_key_exists('prestataire_id', $data)) {
            $prestataire = Prestataire::query()->findOrFail($data['prestataire_id']);
            if ($prestataire->type !== Prestataire::TYPE_STRUCTURE_SANITAIRE) {
                return response()->json([
                    'message' => 'Le prestataire sélectionné n\'est pas une structure sanitaire.',
                ], 422);
            }
        }

        $conventionStructureSanitaire->update($data);
        $conventionStructureSanitaire->load(['mutuelle', 'prestataire.department']);

        return response()->json($conventionStructureSanitaire);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ConventionStructureSanitaire $conventionStructureSanitaire): JsonResponse
    {
        $conventionStructureSanitaire->delete();

        return response()->json(null, 204);
    }
}
