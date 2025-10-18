<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commune extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'department_id',
        'name',
    ];

    /**
     * Get the department that owns the commune.
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Get the mutuelles for the commune.
     */
    public function mutuelles()
    {
        return $this->hasMany(Mutuelle::class);
    }

    /**
     * Get the adherents belonging to the commune.
     */
    public function adherents()
    {
        return $this->hasMany(Adherent::class);
    }
}
