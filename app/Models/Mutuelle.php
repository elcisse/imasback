<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mutuelle extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'commune_id',
        'denomination',
        'sigle',
        'adresse',
        'telephone',
        'email',
        'numero_agrement',
        'desactive',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'desactive' => 'boolean',
    ];

    /**
     * Get the commune that owns the mutuelle.
     */
    public function commune()
    {
        return $this->belongsTo(Commune::class);
    }
}

