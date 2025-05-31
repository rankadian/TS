<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AuthorizeUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $roles = ''): Response
    {
        // Get the list of guards to check
        $guards = ['admin', 'alumni'];

        $user = null;
        $activeGuard = null;

        // Find guard that has an authenticated user
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();
                $activeGuard = $guard;
                break;
            }
        }

        if (!$user) {
            abort(401, 'Unauthenticated.');
        }

        // Get the user's role
        $userRole = $user->role->role_code ?? null;

        // Compare the user's role with the allowed roles
        $allowedRoles = explode('|', $roles);

        if (!in_array($userRole, $allowedRoles)) {
            abort(403, 'Forbidden. You do not have access to this page');
        }

        return $next($request);
    }
}
