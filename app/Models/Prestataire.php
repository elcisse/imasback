<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestataire extends Model
{
    use HasFactory;

    public const TYPE_STRUCTURE_SANITAIRE = 'Structure Sanitaire';
    public const TYPE_PHARMACIE = 'Pharmacie';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'department_id',
        'classification_id',
        'type',
        'denomination',
        'adresse',
        'telephone',
        'email',
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
     * Get the department that owns the prestataire.
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Get the classification associated with the prestataire.
     */
    public function classification()
    {
        return $this->belongsTo(Classification::class);
    }

    /**
     * Get the structure sanitaire conventions for the prestataire.
     */
    public function structureConventions()
    {
        return $this->hasMany(ConventionStructureSanitaire::class);
    }

    /**
     * Get the pharmacy conventions for the prestataire.
     */
    public function pharmacieConventions()
    {
        return $this->hasMany(ConventionPharmacie::class);
    }

    /**
     * Get the letters of guarantee addressed to the prestataire.
     */
    public function lettresGarantie()
    {
        return $this->hasMany(LettreGarantie::class);
    }
}
