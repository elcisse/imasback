<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConventionEntreprise extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'conventions_entreprises';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'mutuelle_id',
        'entreprise_id',
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
        'nombre_beneficiaires',
        'piece_jointe_url',
        'signee_par_mutuelle',
        'signee_par_entreprise',
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
     * Get the mutuelle related to the convention.
     */
    public function mutuelle()
    {
        return $this->belongsTo(Mutuelle::class);
    }

    /**
     * Get the entreprise related to the convention.
     */
    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class);
    }
}
