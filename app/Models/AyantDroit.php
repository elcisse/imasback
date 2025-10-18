<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AyantDroit extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'ayants_droit';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'adherent_id',
        'lien',
        'prenom',
        'nom',
        'date_naissance',
        'sexe',
        'statut',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date_naissance' => 'date',
    ];

    /**
     * Get the adherent associated with the ayant droit.
     */
    public function adherent()
    {
        return $this->belongsTo(Adherent::class);
    }

    /**
     * Get the letters of guarantee linked to this beneficiary.
     */
    public function lettresGarantie()
    {
        return $this->hasMany(LettreGarantie::class);
    }
}
