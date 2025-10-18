<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreConventionPharmacieRequest;
use App\Http\Requests\UpdateConventionPharmacieRequest;
use App\Models\ConventionPharmacie;
use App\Models\Prestataire;
use Illuminate\Http\JsonResponse;

class ConventionPharmacieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $conventions = ConventionPharmacie::query()
            ->with(['mutuelle', 'prestataire.department'])
            ->orderByDesc('date_effet')
            ->get();

        return response()->json($conventions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreConventionPharmacieRequest $request): JsonResponse
    {
        $data = $request->validated();

        $prestataire = Prestataire::query()->findOrFail($data['prestataire_id']);
        if ($prestataire->type !== Prestataire::TYPE_PHARMACIE) {
            return response()->json([
                'message' => 'Le prestataire sélectionné n\'est pas une pharmacie.',
            ], 422);
        }

        $convention = ConventionPharmacie::query()->create($data);
        $convention->load(['mutuelle', 'prestataire.department']);

        return response()->json($convention, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(ConventionPharmacie $conventionPharmacie): JsonResponse
    {
        $conventionPharmacie->load(['mutuelle', 'prestataire.department']);

        return response()->json($conventionPharmacie);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateConventionPharmacieRequest $request, ConventionPharmacie $conventionPharmacie): JsonResponse
    {
        $data = $request->validated();

        if (array_key_exists('prestataire_id', $data)) {
            $prestataire = Prestataire::query()->findOrFail($data['prestataire_id']);
            if ($prestataire->type !== Prestataire::TYPE_PHARMACIE) {
                return response()->json([
                    'message' => 'Le prestataire sélectionné n\'est pas une pharmacie.',
                ], 422);
            }
        }

        $conventionPharmacie->update($data);
        $conventionPharmacie->load(['mutuelle', 'prestataire.department']);

        return response()->json($conventionPharmacie);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ConventionPharmacie $conventionPharmacie): JsonResponse
    {
        $conventionPharmacie->delete();

        return response()->json(null, 204);
    }
}
