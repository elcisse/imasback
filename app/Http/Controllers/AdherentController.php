<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAdherentRequest;
use App\Http\Requests\UpdateAdherentRequest;
use App\Models\Adherent;
use Illuminate\Http\JsonResponse;

class AdherentController extends Controller
{
    /**
     * Display a listing of adherents.
     */
    public function index(): JsonResponse
    {
        $adherents = Adherent::query()
            ->with(['mutuelle', 'entreprise', 'commune'])
            ->orderBy('nom')
            ->orderBy('prenom')
            ->get();

        return response()->json($adherents);
    }

    /**
     * Store a newly created adherent in storage.
     */
    public function store(StoreAdherentRequest $request): JsonResponse
    {
        $adherent = Adherent::query()->create($request->validated());
        $adherent->load(['mutuelle', 'entreprise', 'commune']);

        return response()->json($adherent, 201);
    }

    /**
     * Display the specified adherent.
     */
    public function show(Adherent $adherent): JsonResponse
    {
        $adherent->load(['mutuelle', 'entreprise', 'commune']);

        return response()->json($adherent);
    }

    /**
     * Update the specified adherent in storage.
     */
    public function update(UpdateAdherentRequest $request, Adherent $adherent): JsonResponse
    {
        $adherent->update($request->validated());
        $adherent->load(['mutuelle', 'entreprise', 'commune']);

        return response()->json($adherent);
    }

    /**
     * Remove the specified adherent from storage.
     */
    public function destroy(Adherent $adherent): JsonResponse
    {
        $adherent->delete();

        return response()->json(null, 204);
    }
}
