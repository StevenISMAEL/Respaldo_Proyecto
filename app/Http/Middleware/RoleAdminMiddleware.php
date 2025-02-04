<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Spatie\Permission\Exceptions\UnauthorizedException;

class RoleAdminMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        // Si el usuario tiene el rol admin, permitir el acceso a todo
        if ($request->user()->hasRole('admin')) {
            return $next($request);
        }

        // Si no es admin, verificar el rol solicitado
        if (!$request->user()->hasRole($role)) {
            throw UnauthorizedException::forRoles([$role]);
        }

        return $next($request);
    }
}
