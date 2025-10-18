<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classification extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'classif',
    ];

    /**
     * Get the prestataires that belong to the classification.
     */
    public function prestataires()
    {
        return $this->hasMany(Prestataire::class);
    }
}
