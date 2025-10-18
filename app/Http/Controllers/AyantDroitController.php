<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAyantDroitRequest;
use App\Http\Requests\UpdateAyantDroitRequest;
use App\Models\AyantDroit;
use Illuminate\Http\JsonResponse;

class AyantDroitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $ayantsDroit = AyantDroit::query()
            ->with(['adherent.mutuelle', 'adherent.entreprise'])
            ->orderBy('nom')
            ->orderBy('prenom')
            ->get();

        return response()->json($ayantsDroit);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAyantDroitRequest $request): JsonResponse
    {
        $ayantDroit = AyantDroit::query()->create($request->validated());
        $ayantDroit->load(['adherent.mutuelle', 'adherent.entreprise']);

        return response()->json($ayantDroit, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(AyantDroit $ayantDroit): JsonResponse
    {
        $ayantDroit->load(['adherent.mutuelle', 'adherent.entreprise']);

        return response()->json($ayantDroit);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAyantDroitRequest $request, AyantDroit $ayantDroit): JsonResponse
    {
        $ayantDroit->update($request->validated());
        $ayantDroit->load(['adherent.mutuelle', 'adherent.entreprise']);

        return response()->json($ayantDroit);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AyantDroit $ayantDroit): JsonResponse
    {
        $ayantDroit->delete();

        return response()->json(null, 204);
    }
}
