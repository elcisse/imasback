<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    public const SUPER_ADMIN = 'super-admin';
    public const ADMIN_MUTUELLE = 'admin-mutuelle';
    public const GESTIONNAIRE_PRESTATAIRE = 'gestionnaire-prestataire';
    public const GESTIONNAIRE_COTISATIONS = 'gestionnaire-cotisations';
    public const GESTIONNAIRE_PRESTATIONS = 'gestionnaire-prestations';
    public const AUDITEUR_INTERNE = 'auditeur-interne';

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    /**
     * Users belonging to the role.
     */
    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
