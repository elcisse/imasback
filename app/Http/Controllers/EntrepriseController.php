<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEntrepriseRequest;
use App\Http\Requests\UpdateEntrepriseRequest;
use App\Models\Entreprise;
use Illuminate\Http\JsonResponse;

class EntrepriseController extends Controller
{
    /**
     * Display a listing of the entreprises.
     */
    public function index(): JsonResponse
    {
        $entreprises = Entreprise::query()
            ->with('department')
            ->orderBy('raison_sociale')
            ->get();

        return response()->json($entreprises);
    }

    /**
     * Store a newly created entreprise in storage.
     */
    public function store(StoreEntrepriseRequest $request): JsonResponse
    {
        $entreprise = Entreprise::query()->create($request->validated());
        $entreprise->load('department');

        return response()->json($entreprise, 201);
    }

    /**
     * Display the specified entreprise.
     */
    public function show(Entreprise $entreprise): JsonResponse
    {
        $entreprise->load('department');

        return response()->json($entreprise);
    }

    /**
     * Update the specified entreprise in storage.
     */
    public function update(UpdateEntrepriseRequest $request, Entreprise $entreprise): JsonResponse
    {
        $entreprise->update($request->validated());
        $entreprise->load('department');

        return response()->json($entreprise);
    }

    /**
     * Remove the specified entreprise from storage.
     */
    public function destroy(Entreprise $entreprise): JsonResponse
    {
        $entreprise->delete();

        return response()->json(null, 204);
    }
}

