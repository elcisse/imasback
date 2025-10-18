<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EncaissementCotisation extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'encaissement_cotisations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'emission_cotisation_id',
        'date_encaissement',
        'montant',
        'mode_paiement',
        'reference',
        'statut',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date_encaissement' => 'date',
        'montant' => 'decimal:2',
    ];

    public function emission()
    {
        return $this->belongsTo(EmissionCotisation::class, 'emission_cotisation_id');
    }
}
