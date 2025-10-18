<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAntenneRequest;
use App\Http\Requests\UpdateAntenneRequest;
use App\Models\Antenne;
use Illuminate\Http\JsonResponse;

class AntenneController extends Controller
{
    /**
     * Display a listing of the antennes.
     */
    public function index(): JsonResponse
    {
        $antennes = Antenne::query()
            ->with(['mutuelle', 'department'])
            ->orderBy('nom_antenne')
            ->get();

        return response()->json($antennes);
    }

    /**
     * Store a newly created antenne in storage.
     */
    public function store(StoreAntenneRequest $request): JsonResponse
    {
        $antenne = Antenne::query()->create($request->validated());
        $antenne->load(['mutuelle', 'department']);

        return response()->json($antenne, 201);
    }

    /**
     * Display the specified antenne.
     */
    public function show(Antenne $antenne): JsonResponse
    {
        $antenne->load(['mutuelle', 'department']);

        return response()->json($antenne);
    }

    /**
     * Update the specified antenne in storage.
     */
    public function update(UpdateAntenneRequest $request, Antenne $antenne): JsonResponse
    {
        $antenne->update($request->validated());
        $antenne->load(['mutuelle', 'department']);

        return response()->json($antenne);
    }

    /**
     * Remove the specified antenne from storage.
     */
    public function destroy(Antenne $antenne): JsonResponse
    {
        $antenne->delete();

        return response()->json(null, 204);
    }
}

