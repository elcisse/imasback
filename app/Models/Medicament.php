<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Medicament extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'marque',
        'code',
        'dci_temp',
        'forme',
        'voie',
        'dosage_val',
        'dosage_temp',
        'presentation',
        'barcode',
        'atc_code',
        'exclusion',
        'prix_vente_ht',
        'actif',
        'prix_reference_temp',
        'statut_temp',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'dosage_val' => 'decimal:3',
        'exclusion' => 'boolean',
        'prix_vente_ht' => 'decimal:2',
        'actif' => 'boolean',
        'prix_reference_temp' => 'decimal:2',
    ];
}
