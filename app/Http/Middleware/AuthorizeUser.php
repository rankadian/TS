<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AuthorizeUser
{
    public function handle(Request $request, Closure $next, $roles = ''): Response
    {
        $guard = $this->getActiveGuard($request);

        if (!$guard || !Auth::guard($guard)->check()) {
            abort(401, 'Unauthenticated.');
        }

        $user = Auth::guard($guard)->user();
        $userRole = $user->role->role_code ?? null;
        $allowedRoles = explode('|', $roles);

        if (!in_array($userRole, $allowedRoles)) {
            abort(403, 'Forbidden. You do not have access to this page.');
        }

        return $next($request);
    }

    protected function getActiveGuard(Request $request): ?string
    {
        $routeMiddleware = $request->route()?->gatherMiddleware() ?? [];

        foreach ($routeMiddleware as $middleware) {
            if (str_starts_with($middleware, 'auth:')) {
                return explode(':', $middleware)[1];
            }
        }

        return null;
    }
}
