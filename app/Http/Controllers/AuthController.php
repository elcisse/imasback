<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        /** @var User|null $user */
        $user = User::with(['roles', 'department.region'])
            ->where('email', $credentials['email'])
            ->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            return response()->json([
                'message' => 'Identifiants invalides.',
            ], 422);
        }

        if ($user->desactive) {
            return response()->json([
                'message' => 'Compte désactivé. Contactez un administrateur.',
            ], 423);
        }

        $plainToken = Str::random(80);
        $user->forceFill([
            'api_token' => hash('sha256', $plainToken),
        ])->save();

        return response()->json([
            'token' => $plainToken,
            'token_type' => 'Bearer',
            'roles' => $user->roles->pluck('slug'),
            'user' => $this->transformUser($user),
        ]);
    }

    public function me(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user()->loadMissing(['roles', 'department.region']);

        return response()->json([
            'user' => $this->transformUser($user),
            'roles' => $user->roles->pluck('slug'),
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        /** @var User|null $user */
        $user = $request->user();

        if ($user) {
            $user->forceFill(['api_token' => null])->save();
        }

        return response()->json([
            'message' => 'Déconnexion effectuée.',
        ]);
    }

    /**
     * Helper to expose only the required user fields.
     */
    protected function transformUser(User $user): array
    {
        $roles = $user->roles->map(fn (Role $role) => [
            'id' => $role->id,
            'name' => $role->name,
            'slug' => $role->slug,
        ]);

        $department = $user->department;

        return [
            'id' => $user->id,
            'email' => $user->email,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'display_name' => $user->display_name,
            'desactive' => (bool) $user->desactive,
            'department' => $department ? [
                'id' => $department->id,
                'name' => $department->name,
                'region' => $department->region ? [
                    'id' => $department->region->id,
                    'name' => $department->region->name,
                ] : null,
            ] : null,
            'roles' => $roles,
        ];
    }
}
