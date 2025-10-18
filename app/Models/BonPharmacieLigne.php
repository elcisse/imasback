<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BonPharmacieLigne extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'bon_pharmacie_lignes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'bon_pharmacie_id',
        'numero_ordre',
        'medicament_id',
        'quantite',
        'prix_unitaire',
        'montant',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'quantite' => 'decimal:2',
        'prix_unitaire' => 'decimal:2',
        'montant' => 'decimal:2',
    ];

    /**
     * Get the voucher that owns the line.
     */
    public function bonPharmacie()
    {
        return $this->belongsTo(BonPharmacie::class);
    }

    /**
     * Get the medicament linked to the line.
     */
    public function medicament()
    {
        return $this->belongsTo(Medicament::class);
    }
}
