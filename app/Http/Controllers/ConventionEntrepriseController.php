<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreConventionEntrepriseRequest;
use App\Http\Requests\UpdateConventionEntrepriseRequest;
use App\Models\ConventionEntreprise;
use Illuminate\Http\JsonResponse;

class ConventionEntrepriseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $conventions = ConventionEntreprise::query()
            ->with(['mutuelle', 'entreprise.department'])
            ->orderByDesc('date_effet')
            ->get();

        return response()->json($conventions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreConventionEntrepriseRequest $request): JsonResponse
    {
        $convention = ConventionEntreprise::query()->create($request->validated());
        $convention->load(['mutuelle', 'entreprise.department']);

        return response()->json($convention, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(ConventionEntreprise $conventionEntreprise): JsonResponse
    {
        $conventionEntreprise->load(['mutuelle', 'entreprise.department']);

        return response()->json($conventionEntreprise);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateConventionEntrepriseRequest $request, ConventionEntreprise $conventionEntreprise): JsonResponse
    {
        $conventionEntreprise->update($request->validated());
        $conventionEntreprise->load(['mutuelle', 'entreprise.department']);

        return response()->json($conventionEntreprise);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ConventionEntreprise $conventionEntreprise): JsonResponse
    {
        $conventionEntreprise->delete();

        return response()->json(null, 204);
    }
}
