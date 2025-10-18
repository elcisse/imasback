<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PrestationOfferteLigne extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'libelle',
        'code',
        'tarif',
    ];

    protected $casts = [
        'tarif' => 'decimal:2',
    ];

    public function lettresGarantie()
    {
        return $this->hasMany(LettreGarantieLigne::class);
    }
}
