<?php

use App\Http\Controllers\AdherentController;
use App\Http\Controllers\AntenneController;
use App\Http\Controllers\AyantDroitController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BonPharmacieController;
use App\Http\Controllers\BonPharmacieLigneController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmissionCotisationController;
use App\Http\Controllers\EncaissementCotisationController;
use App\Http\Controllers\EtatAyantDroitController;
use App\Http\Controllers\EtatPrestataireController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\FactureLigneController;
use App\Http\Controllers\ClassificationController;
use App\Http\Controllers\CommuneController;
use App\Http\Controllers\ConventionEntrepriseController;
use App\Http\Controllers\ConventionPharmacieController;
use App\Http\Controllers\ConventionStructureSanitaireController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EntrepriseController;
use App\Http\Controllers\LettreGarantieController;
use App\Http\Controllers\LettreGarantieLigneController;
use App\Http\Controllers\MedicamentController;
use App\Http\Controllers\PrestataireController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::apiResource('regions', RegionController::class);
Route::apiResource('departments', DepartmentController::class);
Route::apiResource('communes', CommuneController::class);
Route::apiResource('antennes', AntenneController::class);
Route::apiResource('entreprises', EntrepriseController::class);
Route::apiResource('classifications', ClassificationController::class);
Route::apiResource('prestataires', PrestataireController::class);
Route::apiResource('medicaments', MedicamentController::class);
Route::apiResource('adherents', AdherentController::class);
Route::apiResource('ayants-droit', AyantDroitController::class)
    ->parameters(['ayants-droit' => 'ayant_droit']);
Route::apiResource('bons-pharmacie', BonPharmacieController::class)
    ->parameters(['bons-pharmacie' => 'bon_pharmacie']);
Route::apiResource('bon-pharmacie-lignes', BonPharmacieLigneController::class)
    ->parameters(['bon-pharmacie-lignes' => 'bon_pharmacie_ligne']);
Route::apiResource('emission-cotisations', EmissionCotisationController::class)
    ->parameters(['emission-cotisations' => 'emission_cotisation']);
Route::apiResource('encaissement-cotisations', EncaissementCotisationController::class)
    ->parameters(['encaissement-cotisations' => 'encaissement_cotisation']);
Route::apiResource('factures', FactureController::class);
Route::apiResource('facture-lignes', FactureLigneController::class)
    ->parameters(['facture-lignes' => 'facture_ligne']);
Route::apiResource('users', UserController::class);

Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware('auth.token')->group(function () {
        Route::get('me', [AuthController::class, 'me']);
        Route::post('logout', [AuthController::class, 'logout']);
    });
});

Route::prefix('dashboard')->group(function () {
    Route::get('overview', [DashboardController::class, 'overview']);
    Route::get('activities', [DashboardController::class, 'activities']);
    Route::get('series', [DashboardController::class, 'series']);
});

Route::prefix('etat/prestataires')->group(function () {
    Route::get('synthese', [EtatPrestataireController::class, 'synthese']);
    Route::get('bons-pharmacie', [EtatPrestataireController::class, 'bonsPharmacie']);
    Route::get('lettres-garantie', [EtatPrestataireController::class, 'lettresGarantie']);
    Route::get('factures', [EtatPrestataireController::class, 'factures']);
    Route::get('performance', [EtatPrestataireController::class, 'performance']);
});
Route::get('etat/ayants-droit/couverture', [EtatAyantDroitController::class, 'couverture']);
Route::apiResource('lettres-garantie', LettreGarantieController::class)
    ->parameters(['lettres-garantie' => 'lettre_garantie']);
Route::apiResource('lettres-garantie-lignes', LettreGarantieLigneController::class)
    ->parameters(['lettres-garantie-lignes' => 'lettre_garantie_ligne']);
Route::apiResource('conventions-structures', ConventionStructureSanitaireController::class)
    ->parameters(['conventions-structures' => 'convention_structure_sanitaire']);
Route::apiResource('conventions-pharmacies', ConventionPharmacieController::class)
    ->parameters(['conventions-pharmacies' => 'convention_pharmacie']);
Route::apiResource('conventions-entreprises', ConventionEntrepriseController::class)
    ->parameters(['conventions-entreprises' => 'convention_entreprise']);
