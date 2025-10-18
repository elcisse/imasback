<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClassificationRequest;
use App\Http\Requests\UpdateClassificationRequest;
use App\Models\Classification;
use Illuminate\Http\JsonResponse;

class ClassificationController extends Controller
{
    /**
     * Display a listing of the classifications.
     */
    public function index(): JsonResponse
    {
        $classifications = Classification::query()
            ->orderBy('classif')
            ->get();

        return response()->json($classifications);
    }

    /**
     * Store a newly created classification in storage.
     */
    public function store(StoreClassificationRequest $request): JsonResponse
    {
        $classification = Classification::query()->create($request->validated());

        return response()->json($classification, 201);
    }

    /**
     * Display the specified classification.
     */
    public function show(Classification $classification): JsonResponse
    {
        return response()->json($classification);
    }

    /**
     * Update the specified classification in storage.
     */
    public function update(UpdateClassificationRequest $request, Classification $classification): JsonResponse
    {
        $classification->update($request->validated());

        return response()->json($classification);
    }

    /**
     * Remove the specified classification from storage.
     */
    public function destroy(Classification $classification): JsonResponse
    {
        $classification->delete();

        return response()->json(null, 204);
    }
}

