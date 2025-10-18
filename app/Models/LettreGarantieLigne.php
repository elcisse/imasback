<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LettreGarantieLigne extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'lettre_garantie_id',
        'prestation_offerte_ligne_id',
    ];

    public function lettreGarantie()
    {
        return $this->belongsTo(LettreGarantie::class);
    }

    public function prestationOfferteLigne()
    {
        return $this->belongsTo(PrestationOfferteLigne::class);
    }
}
