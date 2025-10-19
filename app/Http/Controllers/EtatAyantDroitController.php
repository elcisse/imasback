<?php

namespace App\Http\Controllers;

use App\Models\AyantDroit;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EtatAyantDroitController extends Controller
{
    public function couverture(Request $request): JsonResponse
    {
        $now = Carbon::now();

        $statusDistribution = AyantDroit::query()
            ->select([
                'statut',
                DB::raw('COUNT(*) AS total'),
            ])
            ->groupBy('statut')
            ->pluck('total', 'statut')
            ->map(fn ($value) => (int) $value);

        $expirations = AyantDroit::query()
            ->select([
                DB::raw("DATE_ADD(date_naissance, INTERVAL 18 YEAR) AS date_expiration"),
                DB::raw('COUNT(*) AS total'),
            ])
            ->whereNotNull('date_naissance')
            ->groupBy(DB::raw("DATE_ADD(date_naissance, INTERVAL 18 YEAR)"))
            ->orderBy('date_expiration')
            ->limit(50)
            ->get()
            ->map(fn ($row) => [
                'date' => Carbon::parse($row->date_expiration)->toDateString(),
                'total' => (int) $row->total,
            ]);

        $alerts = AyantDroit::query()
            ->select([
                'ayants_droit.id',
                'ayants_droit.prenom',
                'ayants_droit.nom',
                'ayants_droit.statut',
                'ayants_droit.updated_at',
                'adherents.id as adherent_id',
                'adherents.prenom as adherent_prenom',
                'adherents.nom as adherent_nom',
            ])
            ->join('adherents', 'adherents.id', '=', 'ayants_droit.adherent_id')
            ->whereDate('ayants_droit.updated_at', '<', $now->copy()->subMonths(12)->toDateString())
            ->orderBy('ayants_droit.updated_at')
            ->limit((int) $request->get('limit', 25))
            ->get()
            ->map(fn ($row) => [
                'id' => (int) $row->id,
                'prenom' => $row->prenom,
                'nom' => $row->nom,
                'statut' => $row->statut,
                'derniere_mise_a_jour' => Carbon::parse($row->updated_at)->toDateString(),
                'adherent' => [
                    'id' => (int) $row->adherent_id,
                    'prenom' => $row->adherent_prenom,
                    'nom' => $row->adherent_nom,
                ],
            ]);

        return response()->json([
            'generation' => $now->toIso8601String(),
            'distribution_statuts' => $statusDistribution,
            'expirations_estimees' => $expirations,
            'alertes_mise_a_jour' => $alerts,
        ]);
    }
}
