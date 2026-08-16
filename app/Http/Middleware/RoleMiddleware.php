<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next, ...$roles)
    {
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login');
        }

        // Admin é super-perfil: tem acesso a qualquer área protegida por role.
        if ($user->role === 'admin') {
            return $next($request);
        }

        if (!in_array($user->role, $roles, true)) {
            abort(403);
        }

        return $next($request);
    }
}
