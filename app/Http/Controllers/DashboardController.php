<?php

namespace App\Http\Controllers;

use App\Models\Adherent;
use App\Models\AyantDroit;
use App\Models\BonPharmacie;
use App\Models\EncaissementCotisation;
use App\Models\EmissionCotisation;
use App\Models\Facture;
use App\Models\LettreGarantie;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function overview(Request $request): JsonResponse
    {
        $now = Carbon::now();
        $window = (int) $request->get('window_days', 30);
        $since = $now->copy()->subDays($window);

        $overview = [
            'generation' => $now->toIso8601String(),
            'window_days' => $window,
            'totals' => [
                'adherents' => [
                    'total' => Adherent::count(),
                    'nouveaux' => Adherent::where('created_at', '>=', $since)->count(),
                ],
                'ayants_droit' => [
                    'total' => AyantDroit::count(),
                    'nouveaux' => AyantDroit::where('created_at', '>=', $since)->count(),
                ],
                'bons_pharmacie' => [
                    'utilises' => BonPharmacie::where('statut', 'utilise')
                        ->whereDate('date_emission', '>=', $since->toDateString())
                        ->count(),
                    'annules' => BonPharmacie::where('statut', 'annule')
                        ->whereDate('date_emission', '>=', $since->toDateString())
                        ->count(),
                ],
                'lettres_garantie' => [
                    'utilisees' => LettreGarantie::where('statut', 'utilisee')
                        ->whereDate('date_emission', '>=', $since->toDateString())
                        ->count(),
                    'annulees' => LettreGarantie::where('statut', 'annulee')
                        ->whereDate('date_emission', '>=', $since->toDateString())
                        ->count(),
                ],
                'factures' => [
                    'montant_restant' => (float) Facture::sum('montant_restant'),
                    'reglees' => Facture::where('statut', 'reglee')
                        ->whereDate('updated_at', '>=', $since->toDateString())
                        ->count(),
                    'litiges' => Facture::where('statut', 'en_litige')->count(),
                ],
                'cotisations' => [
                    'emises' => (float) EmissionCotisation::whereDate('date_emission', '>=', $since->toDateString())
                        ->sum('montant'),
                    'encaissees' => (float) EncaissementCotisation::whereDate('date_encaissement', '>=', $since->toDateString())
                        ->sum('montant'),
                ],
            ],
        ];

        return response()->json($overview);
    }

    public function activities(Request $request): JsonResponse
    {
        $limit = (int) $request->get('limit', 20);

        $events = collect()
            ->merge($this->mapEvents(
                Adherent::orderByDesc('created_at')->limit($limit)->get(),
                fn ($item) => [
                    'type' => 'adherent',
                    'id' => (int) $item->id,
                    'numero' => $item->matricule,
                    'libelle' => trim("{$item->prenom} {$item->nom}"),
                    'date' => $item->created_at,
                    'meta' => [
                        'mutuelle_id' => $item->mutuelle_id,
                        'statut' => $item->statut,
                    ],
                ]
            ))
            ->merge($this->mapEvents(
                AyantDroit::orderByDesc('created_at')->limit($limit)->get(),
                fn ($item) => [
                    'type' => 'ayant_droit',
                    'id' => (int) $item->id,
                    'numero' => null,
                    'libelle' => trim("{$item->prenom} {$item->nom}"),
                    'date' => $item->created_at,
                    'meta' => [
                        'adherent_id' => $item->adherent_id,
                        'statut' => $item->statut,
                    ],
                ]
            ))
            ->merge($this->mapEvents(
                BonPharmacie::orderByDesc('date_emission')->limit($limit)->get(),
                fn ($item) => [
                    'type' => 'bon_pharmacie',
                    'id' => (int) $item->id,
                    'numero' => $item->numero,
                    'libelle' => $item->statut,
                    'date' => Carbon::parse($item->date_emission),
                    'meta' => [
                        'prestataire_id' => $item->prestataire_id,
                        'mutuelle_id' => $item->mutuelle_id,
                        'statut' => $item->statut,
                    ],
                ]
            ))
            ->merge($this->mapEvents(
                LettreGarantie::orderByDesc('date_emission')->limit($limit)->get(),
                fn ($item) => [
                    'type' => 'lettre_garantie',
                    'id' => (int) $item->id,
                    'numero' => $item->numero,
                    'libelle' => $item->statut,
                    'date' => Carbon::parse($item->date_emission),
                    'meta' => [
                        'prestataire_id' => $item->prestataire_id,
                        'mutuelle_id' => $item->mutuelle_id,
                        'statut' => $item->statut,
                    ],
                ]
            ))
            ->merge($this->mapEvents(
                Facture::orderByDesc('date_facture')->limit($limit)->get(),
                fn ($item) => [
                    'type' => 'facture',
                    'id' => (int) $item->id,
                    'numero' => $item->numero,
                    'libelle' => $item->statut,
                    'date' => Carbon::parse($item->date_facture),
                    'meta' => [
                        'montant_ht' => (float) $item->montant_ht,
                        'montant_restant' => (float) $item->montant_restant,
                    ],
                ]
            ))
            ->merge($this->mapEvents(
                EncaissementCotisation::orderByDesc('date_encaissement')->limit($limit)->get(),
                fn ($item) => [
                    'type' => 'encaissement_cotisation',
                    'id' => (int) $item->id,
                    'numero' => null,
                    'libelle' => $item->mode_paiement,
                    'date' => Carbon::parse($item->date_encaissement),
                    'meta' => [
                        'montant' => (float) $item->montant,
                        'statut' => $item->statut,
                    ],
                ]
            ))
            ->sortByDesc('date')
            ->take($limit)
            ->map(function ($item) {
                $item['date'] = $item['date'] instanceof Carbon
                    ? $item['date']->toDateTimeString()
                    : Carbon::parse($item['date'])->toDateTimeString();

                return $item;
            })
            ->values();

        return response()->json([
            'generation' => Carbon::now()->toIso8601String(),
            'data' => $events,
        ]);
    }

    public function series(Request $request): JsonResponse
    {
        $months = (int) $request->get('months', 6);
        $end = Carbon::now()->startOfMonth();
        $start = $end->copy()->subMonths($months - 1);

        $adherents = $this->monthlyCount(Adherent::class, 'created_at', $start, $end);
        $ayants = $this->monthlyCount(AyantDroit::class, 'created_at', $start, $end);
        $bons = $this->monthlyCount(BonPharmacie::class, 'date_emission', $start, $end);
        $factures = $this->monthlySum(Facture::class, 'date_facture', 'montant_couvert', $start, $end);
        $encaissements = $this->monthlySum(EncaissementCotisation::class, 'date_encaissement', 'montant', $start, $end);

        $labels = [];
        $cursor = $start->copy();
        while ($cursor <= $end) {
            $labels[] = $cursor->format('Y-m');
            $cursor->addMonth();
        }

        $series = collect($labels)->map(function ($label) use ($adherents, $ayants, $bons, $factures, $encaissements) {
            return [
                'mois' => $label,
                'adherents' => $adherents[$label] ?? 0,
                'ayants_droit' => $ayants[$label] ?? 0,
                'bons_pharmacie' => $bons[$label] ?? 0,
                'montant_factures_couvert' => $factures[$label] ?? 0.0,
                'montant_encaissements' => $encaissements[$label] ?? 0.0,
            ];
        });

        return response()->json([
            'periode' => [
                'from' => $start->toDateString(),
                'to' => $end->copy()->endOfMonth()->toDateString(),
            ],
            'series' => $series,
        ]);
    }

    /**
     * @template TModel of \Illuminate\Database\Eloquent\Model
     * @param class-string<TModel> $modelClass
     * @return array<string,int>
     */
    private function monthlyCount(string $modelClass, string $dateColumn, Carbon $start, Carbon $end): array
    {
        return $modelClass::query()
            ->select([
                DB::raw("DATE_FORMAT({$dateColumn}, '%Y-%m') AS month"),
                DB::raw('COUNT(*) AS total'),
            ])
            ->whereBetween($dateColumn, [$start->toDateString(), $end->copy()->endOfMonth()->toDateString()])
            ->groupBy('month')
            ->pluck('total', 'month')
            ->map(fn ($value) => (int) $value)
            ->all();
    }

    /**
     * @template TModel of \Illuminate\Database\Eloquent\Model
     * @param class-string<TModel> $modelClass
     * @return array<string,float>
     */
    private function monthlySum(string $modelClass, string $dateColumn, string $field, Carbon $start, Carbon $end): array
    {
        return $modelClass::query()
            ->select([
                DB::raw("DATE_FORMAT({$dateColumn}, '%Y-%m') AS month"),
                DB::raw("SUM({$field}) AS total"),
            ])
            ->whereBetween($dateColumn, [$start->toDateString(), $end->copy()->endOfMonth()->toDateString()])
            ->groupBy('month')
            ->pluck('total', 'month')
            ->map(fn ($value) => (float) $value)
            ->all();
    }

    /**
     * @template T of \Illuminate\Database\Eloquent\Model
     * @param \Illuminate\Support\Collection<int,T> $items
     * @param callable $mapper
     * @return \Illuminate\Support\Collection<int,array<string,mixed>>
     */
    private function mapEvents(Collection $items, callable $mapper): Collection
    {
        return $items->map($mapper);
    }
}
