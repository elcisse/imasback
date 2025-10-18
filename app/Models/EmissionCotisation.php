<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmissionCotisation extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'emission_cotisations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'numero',
        'mutuelle_id',
        'adherent_id',
        'date_emission',
        'periode_debut',
        'periode_fin',
        'montant',
        'statut',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date_emission' => 'date',
        'periode_debut' => 'date',
        'periode_fin' => 'date',
        'montant' => 'decimal:2',
    ];

    public function mutuelle()
    {
        return $this->belongsTo(Mutuelle::class);
    }

    public function adherent()
    {
        return $this->belongsTo(Adherent::class);
    }

    public function encaissements()
    {
        return $this->hasMany(EncaissementCotisation::class)->orderByDesc('date_encaissement');
    }
}
