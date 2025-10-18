<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMedicamentRequest;
use App\Http\Requests\UpdateMedicamentRequest;
use App\Models\Medicament;
use Illuminate\Http\JsonResponse;

class MedicamentController extends Controller
{
    /**
     * Display a listing of medicaments.
     */
    public function index(): JsonResponse
    {
        $medicaments = Medicament::query()
            ->orderBy('marque')
            ->orderBy('code')
            ->get();

        return response()->json($medicaments);
    }

    /**
     * Store a newly created medicament in storage.
     */
    public function store(StoreMedicamentRequest $request): JsonResponse
    {
        $medicament = Medicament::query()->create($request->validated());

        return response()->json($medicament, 201);
    }

    /**
     * Display the specified medicament.
     */
    public function show(Medicament $medicament): JsonResponse
    {
        return response()->json($medicament);
    }

    /**
     * Update the specified medicament in storage.
     */
    public function update(UpdateMedicamentRequest $request, Medicament $medicament): JsonResponse
    {
        $medicament->update($request->validated());

        return response()->json($medicament);
    }

    /**
     * Remove the specified medicament from storage.
     */
    public function destroy(Medicament $medicament): JsonResponse
    {
        $medicament->delete();

        return response()->json(null, 204);
    }
}

