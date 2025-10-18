<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mutuelle extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'commune_id',
        'denomination',
        'sigle',
        'adresse',
        'telephone',
        'email',
        'numero_agrement',
        'desactive',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'desactive' => 'boolean',
    ];

    /**
     * Get the commune that owns the mutuelle.
     */
    public function commune()
    {
        return $this->belongsTo(Commune::class);
    }

    /**
     * Get the antennes for the mutuelle.
     */
    public function antennes()
    {
        return $this->hasMany(Antenne::class);
    }

    /**
     * Get the structure sanitaire conventions for the mutuelle.
     */
    public function structureConventions()
    {
        return $this->hasMany(ConventionStructureSanitaire::class);
    }

    /**
     * Get the pharmacy conventions for the mutuelle.
     */
    public function pharmacieConventions()
    {
        return $this->hasMany(ConventionPharmacie::class);
    }

    /**
     * Get the enterprise conventions for the mutuelle.
     */
    public function entrepriseConventions()
    {
        return $this->hasMany(ConventionEntreprise::class);
    }

    /**
     * Get the adherents associated with the mutuelle.
     */
    public function adherents()
    {
        return $this->hasMany(Adherent::class);
    }

    /**
     * Get the letters of guarantee issued by the mutuelle.
     */
    public function lettresGarantie()
    {
        return $this->hasMany(LettreGarantie::class);
    }

    /**
     * Get the pharmacy vouchers issued by the mutuelle.
     */
    public function bonsPharmacie()
    {
        return $this->hasMany(BonPharmacie::class);
    }

    /**
     * Get the contribution emissions for the mutuelle.
     */
    public function emissionCotisations()
    {
        return $this->hasMany(EmissionCotisation::class);
    }

    /**
     * Get the invoices issued to the mutuelle.
     */
    public function factures()
    {
        return $this->hasMany(Facture::class);
    }
}
