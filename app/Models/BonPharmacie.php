<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BonPharmacie extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'bons_pharmacie';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'numero',
        'mutuelle_id',
        'prestataire_id',
        'adherent_id',
        'ayant_droit_id',
        'date_emission',
        'taux_couverture',
        'statut',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date_emission' => 'date',
        'taux_couverture' => 'decimal:2',
    ];

    /**
     * Get the mutuelle that issued the voucher.
     */
    public function mutuelle()
    {
        return $this->belongsTo(Mutuelle::class);
    }

    /**
     * Get the prestataire that should honor the voucher.
     */
    public function prestataire()
    {
        return $this->belongsTo(Prestataire::class);
    }

    /**
     * Get the adherent associated with the voucher.
     */
    public function adherent()
    {
        return $this->belongsTo(Adherent::class);
    }

    /**
     * Get the beneficiary linked to the voucher.
     */
    public function ayantDroit()
    {
        return $this->belongsTo(AyantDroit::class);
    }

    /**
     * Get the detailed lines attached to the voucher.
     */
    public function lignes()
    {
        return $this->hasMany(BonPharmacieLigne::class)->orderBy('numero_ordre');
    }
}
