<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'region_id',
        'name',
    ];

    /**
     * Get the region that owns the department.
     */
    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    /**
     * Get the communes for the department.
     */
    public function communes()
    {
        return $this->hasMany(Commune::class);
    }
}
