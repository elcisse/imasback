<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LettreGarantie extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'lettres_garantie';

    protected $fillable = [
        'numero',
        'mutuelle_id',
        'prestataire_id',
        'adherent_id',
        'ayant_droit_id',
        'date_emission',
        'date_validite',
        'statut',
        'taux',
    ];

    protected $casts = [
        'date_emission' => 'date',
        'date_validite' => 'date',
        'taux' => 'decimal:2',
    ];

    public function mutuelle()
    {
        return $this->belongsTo(Mutuelle::class);
    }

    public function prestataire()
    {
        return $this->belongsTo(Prestataire::class);
    }

    public function adherent()
    {
        return $this->belongsTo(Adherent::class);
    }

    public function ayantDroit()
    {
        return $this->belongsTo(AyantDroit::class);
    }

    public function lignes()
    {
        return $this->hasMany(LettreGarantieLigne::class);
    }
}
