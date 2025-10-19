<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticateWithApiToken
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken() ?? $request->query('token');

        if (! $token) {
            return $this->unauthorized();
        }

        $user = User::with(['roles', 'department.region'])
            ->where('api_token', hash('sha256', $token))
            ->first();

        if (! $user) {
            return $this->unauthorized();
        }

        if ($user->desactive) {
            return response()->json([
                'message' => 'Compte désactivé.',
            ], 423);
        }

        Auth::setUser($user);
        $request->setUserResolver(static fn () => $user);

        return $next($request);
    }

    protected function unauthorized(): JsonResponse
    {
        return response()->json([
            'message' => 'Unauthenticated.',
        ], 401);
    }
}
