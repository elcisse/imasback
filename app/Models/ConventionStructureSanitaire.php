<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConventionStructureSanitaire extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'conventions_structure_sanitaires';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'mutuelle_id',
        'prestataire_id',
        'numero',
        'objet',
        'date_signature',
        'date_effet',
        'date_fin',
        'statut',
        'taux_couverture_defaut',
        'plafond_annuel_benef',
        'mode_facturation',
        'periodicite_facturation',
        'delai_paiement_jours',
        'piece_jointe_url',
        'signee_par_mutuelle',
        'signee_par_prestataire',
        'clauses',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date_signature' => 'date',
        'date_effet' => 'date',
        'date_fin' => 'date',
        'taux_couverture_defaut' => 'decimal:2',
        'plafond_annuel_benef' => 'decimal:2',
        'clauses' => 'array',
    ];

    /**
     * Get the mutuelle that owns the convention.
     */
    public function mutuelle()
    {
        return $this->belongsTo(Mutuelle::class);
    }

    /**
     * Get the prestataire linked to the convention.
     */
    public function prestataire()
    {
        return $this->belongsTo(Prestataire::class)
            ->where('type', Prestataire::TYPE_STRUCTURE_SANITAIRE);
    }
}
