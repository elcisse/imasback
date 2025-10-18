<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entreprise extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'department_id',
        'raison_sociale',
        'adresse',
        'telephone',
        'email',
        'ninea',
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
     * Get the department that owns the entreprise.
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Get the conventions signed with the entreprise.
     */
    public function conventions()
    {
        return $this->hasMany(ConventionEntreprise::class);
    }

    /**
     * Get the adherents linked to the entreprise.
     */
    public function adherents()
    {
        return $this->hasMany(Adherent::class);
    }
}
