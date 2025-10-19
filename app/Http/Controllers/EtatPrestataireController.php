<?php

namespace App\Http\Controllers;

use App\Models\BonPharmacie;
use App\Models\Facture;
use App\Models\LettreGarantie;
use App\Models\Prestataire;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class EtatPrestataireController extends Controller
{
    public function synthese(Request $request): JsonResponse
    {
        [$from, $to] = $this->extractPeriod($request);

        $factures = Facture::query()
            ->select([
                'prestataires.id as prestataire_id',
                'prestataires.denomination',
                'prestataires.type',
                DB::raw('SUM(factures.montant_ht) AS montant_ht'),
                DB::raw('SUM(factures.montant_couvert) AS montant_couvert'),
                DB::raw('SUM(factures.montant_restant) AS montant_restant'),
                DB::raw("SUM(CASE WHEN factures.statut IN ('recue','en_litige','validee') THEN 1 ELSE 0 END) AS dossiers_ouverts"),
            ])
            ->join('prestataires', 'prestataires.id', '=', 'factures.prestataire_id')
            ->when($from, fn ($query) => $query->whereDate('factures.date_facture', '>=', $from))
            ->when($to, fn ($query) => $query->whereDate('factures.date_facture', '<=', $to))
            ->groupBy('prestataires.id', 'prestataires.denomination', 'prestataires.type')
            ->get()
            ->map(fn ($row) => [
                'prestataire' => [
                    'id' => (int) $row->prestataire_id,
                    'denomination' => $row->denomination,
                    'type' => $row->type,
                ],
                'montant_ht' => (float) $row->montant_ht,
                'montant_couvert' => (float) $row->montant_couvert,
                'montant_restant' => (float) $row->montant_restant,
                'dossiers_ouverts' => (int) $row->dossiers_ouverts,
            ]);

        return response()->json([
            'période' => $this->formatPeriod($from, $to),
            'data' => $factures,
        ]);
    }

    public function bonsPharmacie(Request $request): JsonResponse
    {
        [$from, $to] = $this->extractPeriod($request);

        $bons = BonPharmacie::query()
            ->select([
                'prestataires.id as prestataire_id',
                'prestataires.denomination',
                'prestataires.type',
                DB::raw("SUM(CASE WHEN bons_pharmacie.statut = 'utilise' THEN 1 ELSE 0 END) AS bons_utilises"),
                DB::raw("SUM(CASE WHEN bons_pharmacie.statut = 'annule' THEN 1 ELSE 0 END) AS bons_annules"),
                DB::raw("SUM(CASE WHEN bons_pharmacie.statut = 'brouillon' THEN 1 ELSE 0 END) AS bons_brouillons"),
                DB::raw('AVG(bons_pharmacie.taux_couverture) AS taux_couverture_moyen'),
            ])
            ->join('prestataires', 'prestataires.id', '=', 'bons_pharmacie.prestataire_id')
            ->when($from, fn ($query) => $query->whereDate('bons_pharmacie.date_emission', '>=', $from))
            ->when($to, fn ($query) => $query->whereDate('bons_pharmacie.date_emission', '<=', $to))
            ->groupBy('prestataires.id', 'prestataires.denomination', 'prestataires.type')
            ->get()
            ->map(fn ($row) => [
                'prestataire' => [
                    'id' => (int) $row->prestataire_id,
                    'denomination' => $row->denomination,
                    'type' => $row->type,
                ],
                'bons_utilises' => (int) $row->bons_utilises,
                'bons_annules' => (int) $row->bons_annules,
                'bons_brouillons' => (int) $row->bons_brouillons,
                'taux_couverture_moyen' => $row->taux_couverture_moyen !== null ? (float) $row->taux_couverture_moyen : null,
            ]);

        return response()->json([
            'période' => $this->formatPeriod($from, $to),
            'data' => $bons,
        ]);
    }

    public function lettresGarantie(Request $request): JsonResponse
    {
        [$from, $to] = $this->extractPeriod($request);

        $lettres = LettreGarantie::query()
            ->select([
                'prestataires.id as prestataire_id',
                'prestataires.denomination',
                'prestataires.type',
                DB::raw("SUM(CASE WHEN lettres_garantie.statut = 'utilisee' THEN 1 ELSE 0 END) AS lettres_honorees"),
                DB::raw("SUM(CASE WHEN lettres_garantie.statut = 'annulee' THEN 1 ELSE 0 END) AS lettres_annulees"),
                DB::raw("AVG(CASE WHEN lettres_garantie.date_validite IS NOT NULL THEN DATEDIFF(lettres_garantie.date_validite, lettres_garantie.date_emission) END) AS delai_moyen_traitement"),
            ])
            ->join('prestataires', 'prestataires.id', '=', 'lettres_garantie.prestataire_id')
            ->where('prestataires.type', Prestataire::TYPE_STRUCTURE_SANITAIRE)
            ->when($from, fn ($query) => $query->whereDate('lettres_garantie.date_emission', '>=', $from))
            ->when($to, fn ($query) => $query->whereDate('lettres_garantie.date_emission', '<=', $to))
            ->groupBy('prestataires.id', 'prestataires.denomination', 'prestataires.type')
            ->get()
            ->map(fn ($row) => [
                'prestataire' => [
                    'id' => (int) $row->prestataire_id,
                    'denomination' => $row->denomination,
                    'type' => $row->type,
                ],
                'lettres_honorees' => (int) $row->lettres_honorees,
                'lettres_annulees' => (int) $row->lettres_annulees,
                'delai_moyen_traitement_jours' => $row->delai_moyen_traitement !== null ? (float) $row->delai_moyen_traitement : null,
            ]);

        return response()->json([
            'période' => $this->formatPeriod($from, $to),
            'data' => $lettres,
        ]);
    }

    public function factures(Request $request): JsonResponse
    {
        [$from, $to] = $this->extractPeriod($request);

        $pipeline = Facture::query()
            ->select([
                'prestataires.id as prestataire_id',
                'prestataires.denomination',
                'prestataires.type',
                'factures.statut',
                DB::raw('COUNT(*) AS total'),
                DB::raw('SUM(factures.montant_ht) AS montant_ht'),
                DB::raw('SUM(factures.montant_couvert) AS montant_couvert'),
                DB::raw('SUM(factures.montant_restant) AS montant_restant'),
            ])
            ->join('prestataires', 'prestataires.id', '=', 'factures.prestataire_id')
            ->when($from, fn ($query) => $query->whereDate('factures.date_facture', '>=', $from))
            ->when($to, fn ($query) => $query->whereDate('factures.date_facture', '<=', $to))
            ->groupBy('prestataires.id', 'prestataires.denomination', 'prestataires.type', 'factures.statut')
            ->get()
            ->groupBy('prestataire_id')
            ->map(function ($rows) {
                $first = $rows->first();

                return [
                    'prestataire' => [
                        'id' => (int) $first->prestataire_id,
                        'denomination' => $first->denomination,
                        'type' => $first->type,
                    ],
                    'statuts' => $rows->map(function ($row) {
                        return [
                            'statut' => $row->statut,
                            'total' => (int) $row->total,
                            'montant_ht' => (float) $row->montant_ht,
                            'montant_couvert' => (float) $row->montant_couvert,
                            'montant_restant' => (float) $row->montant_restant,
                        ];
                    })->values(),
                ];
            })
            ->values();

        return response()->json([
            'période' => $this->formatPeriod($from, $to),
            'data' => $pipeline,
        ]);
    }

    public function performance(Request $request): JsonResponse
    {
        [$from, $to] = $this->extractPeriod($request);

        $factures = Facture::query()
            ->join('prestataires', 'prestataires.id', '=', 'factures.prestataire_id')
            ->when($from, fn ($query) => $query->whereDate('factures.date_facture', '>=', $from))
            ->when($to, fn ($query) => $query->whereDate('factures.date_facture', '<=', $to));

        $delais = (clone $factures)
            ->where('statut', 'reglee')
            ->select([
                'prestataire_id',
                DB::raw('AVG(DATEDIFF(factures.updated_at, factures.date_facture)) AS delai_moyen'),
            ])
            ->groupBy('prestataire_id')
            ->pluck('delai_moyen', 'prestataire_id');

        $totaux = (clone $factures)
            ->select([
                'prestataire_id',
                'prestataires.denomination',
                'prestataires.type',
                DB::raw('COUNT(*) AS total'),
                DB::raw("SUM(CASE WHEN factures.statut IN ('en_litige','annulee') THEN 1 ELSE 0 END) AS rejets"),
                DB::raw('SUM(factures.montant_couvert) AS montant_couvert'),
            ])
            ->groupBy('prestataire_id', 'prestataires.denomination', 'prestataires.type')
            ->get()
            ->map(function ($row) use ($delais) {
                $total = (int) $row->total;
                $rejets = (int) $row->rejets;

                return [
                    'prestataire' => [
                        'id' => (int) $row->prestataire_id,
                        'denomination' => $row->denomination,
                        'type' => $row->type,
                    ],
                    'delai_moyen_reglement_jours' => $delais->has($row->prestataire_id)
                        ? (float) $delais[$row->prestataire_id]
                        : null,
                    'taux_rejet' => $total > 0 ? round($rejets / $total, 4) : null,
                    'montant_couvert' => (float) $row->montant_couvert,
                ];
            })
            ->values();

        $topPrestataires = $totaux
            ->sortByDesc('montant_couvert')
            ->take((int) $request->get('limit', 5))
            ->values();

        return response()->json([
            'période' => $this->formatPeriod($from, $to),
            'data' => [
                'prestataires' => $totaux,
                'top_prestataires' => $topPrestataires,
            ],
        ]);
    }

    /**
     * @return array{0:Carbon|null,1:Carbon|null}
     */
    private function extractPeriod(Request $request): array
    {
        $from = $request->filled('from') ? Carbon::parse($request->get('from'))->startOfDay() : null;
        $to = $request->filled('to') ? Carbon::parse($request->get('to'))->endOfDay() : null;

        return [$from, $to];
    }

    private function formatPeriod(?Carbon $from, ?Carbon $to): array
    {
        return [
            'from' => $from?->toDateString(),
            'to' => $to?->toDateString(),
        ];
    }
}
