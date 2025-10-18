<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Adherent extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'mutuelle_id',
        'entreprise_id',
        'matricule',
        'prenom',
        'nom',
        'sexe',
        'date_naissance',
        'lieu_naissance',
        'numero_cni',
        'etat_civil',
        'commune_id',
        'telephone',
        'email',
        'date_adhesion',
        'statut',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date_naissance' => 'date',
        'date_adhesion' => 'date',
    ];

    /**
     * Get the mutuelle associated with the adherent.
     */
    public function mutuelle()
    {
        return $this->belongsTo(Mutuelle::class);
    }

    /**
     * Get the entreprise associated with the adherent.
     */
    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class);
    }

    /**
     * Get the commune associated with the adherent.
     */
    public function commune()
    {
        return $this->belongsTo(Commune::class);
    }

    /**
     * Get the ayants droit linked to the adherent.
     */
    public function ayantsDroit()
    {
        return $this->hasMany(AyantDroit::class);
    }

    /**
     * Get the letters of guarantee related to the adherent.
     */
    public function lettresGarantie()
    {
        return $this->hasMany(LettreGarantie::class);
    }
}
