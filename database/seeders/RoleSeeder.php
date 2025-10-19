<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Super Admin',
                'slug' => Role::SUPER_ADMIN,
                'description' => 'Gère les comptes, droits, paramètres globaux, accès complet.',
            ],
            [
                'name' => 'Administrateur Mutuelle',
                'slug' => Role::ADMIN_MUTUELLE,
                'description' => 'Pilote la mutuelle (adhérents, ayants droit, cotisations, rapports internes).',
            ],
            [
                'name' => 'Gestionnaire Prestataire',
                'slug' => Role::GESTIONNAIRE_PRESTATAIRE,
                'description' => 'Gère les conventions, bons, lettres et factures pour son établissement.',
            ],
            [
                'name' => 'Gestionnaire Cotisations',
                'slug' => Role::GESTIONNAIRE_COTISATIONS,
                'description' => 'Suit émissions/encaissements, relances et régularisations.',
            ],
            [
                'name' => 'Gestionnaire Prestations',
                'slug' => Role::GESTIONNAIRE_PRESTATIONS,
                'description' => 'Instruit les dossiers (bons, lettres, litiges), valide les remboursements.',
            ],
            [
                'name' => 'Auditeur Interne',
                'slug' => Role::AUDITEUR_INTERNE,
                'description' => 'Accès aux dashboards/exports, restrictions sur les opérations métiers.',
            ],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['slug' => $role['slug']],
                $role
            );
        }
    }
}
