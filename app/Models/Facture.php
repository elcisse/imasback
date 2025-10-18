<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Facture extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'numero',
        'mutuelle_id',
        'prestataire_id',
        'date_facture',
        'date_echeance',
        'montant_ht',
        'montant_couvert',
        'montant_restant',
        'statut',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date_facture' => 'date',
        'date_echeance' => 'date',
        'montant_ht' => 'decimal:2',
        'montant_couvert' => 'decimal:2',
        'montant_restant' => 'decimal:2',
    ];

    public function mutuelle()
    {
        return $this->belongsTo(Mutuelle::class);
    }

    public function prestataire()
    {
        return $this->belongsTo(Prestataire::class);
    }

    public function lignes()
    {
        return $this->hasMany(FactureLigne::class)->orderBy('id');
    }
}
