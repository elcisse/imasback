<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Antenne extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'mutuelle_id',
        'department_id',
        'nom_antenne',
        'adresse',
        'telephone',
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
     * Get the mutuelle that owns the antenne.
     */
    public function mutuelle()
    {
        return $this->belongsTo(Mutuelle::class);
    }

    /**
     * Get the department that owns the antenne.
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
