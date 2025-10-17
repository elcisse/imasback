<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'region',
        'code',
    ];

    /**
     * Get the departments for the region.
     */
    public function departments()
    {
        return $this->hasMany(Department::class);
    }

    /**
     * Get all communes that belong to the region through departments.
     */
    public function communes()
    {
        return $this->hasManyThrough(Commune::class, Department::class);
    }
}
