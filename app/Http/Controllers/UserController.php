<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(): JsonResponse
    {
        $users = User::with(['roles', 'department.region'])
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get();

        return response()->json($users);
    }

    public function store(StoreUserRequest $request): JsonResponse
    {
        $data = $request->validated();
        $roles = $data['roles'] ?? [];
        unset($data['roles']);

        $data['name'] = trim("{$data['first_name']} {$data['last_name']}");
        $data['desactive'] = $data['desactive'] ?? false;
        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);
        if ($roles) {
            $roleIds = Role::whereIn('slug', $roles)->pluck('id');
            $user->roles()->sync($roleIds);
        }
        $user->load(['roles', 'department.region']);

        return response()->json($user, 201);
    }

    public function show(User $user): JsonResponse
    {
        $user->load(['roles', 'department.region']);

        return response()->json($user);
    }

    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        $data = $request->validated();
        $roles = $data['roles'] ?? null;
        unset($data['roles']);

        if (isset($data['first_name']) || isset($data['last_name'])) {
            $firstName = $data['first_name'] ?? $user->first_name;
            $lastName = $data['last_name'] ?? $user->last_name;
            $data['name'] = trim("{$firstName} {$lastName}");
        }

        if (array_key_exists('password', $data)) {
            if ($data['password']) {
                $data['password'] = Hash::make($data['password']);
            } else {
                unset($data['password']);
            }
        }

        $user->update($data);

        if ($roles !== null) {
            $roleIds = Role::whereIn('slug', $roles)->pluck('id');
            $user->roles()->sync($roleIds);
        }

        $user->load('roles');

        return response()->json($user);
    }

    public function destroy(User $user): JsonResponse
    {
        $user->delete();

        return response()->json(null, 204);
    }
}
