<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Domain;

class ResolveCustomDomain
{
    public function handle(Request $request, Closure $next)
    {
        // Evita interferir em rotas explícitas (/s/{slug}, /admin, /login, etc.)
        if ($request->is('s/*') || $request->is('admin/*') || $request->is('login*')) {
            return $next($request);
        }

        $host = $request->getHost();

        $domain = Domain::where('domain', $host)
            ->where('status', 'active')
            ->with('site.templateVersion')
            ->first();

        if ($domain && $domain->site && $domain->site->status === 'published') {
            // Injeta o site resolvido na request
            $request->attributes->set('resolvedSite', $domain->site);
        }

        return $next($request);
    }
}
