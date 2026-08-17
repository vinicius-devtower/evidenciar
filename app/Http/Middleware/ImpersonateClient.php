<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Suporte a "ver como cliente" (impersonation) pro Painel Suporte.
 *
 * Quando um admin/support clica em "Acessar como cliente" em
 * /suporte/assinantes/{id}, guardamos o client_id alvo na sessão. Esse
 * middleware, rodando em toda requisição, troca o client_id do usuário
 * autenticado EM MEMÓRIA (nunca persiste no banco) — assim qualquer
 * controller que já usa Auth::user()->client / client_id (SistemaController,
 * SiteController, SiteEditorController, PublicationRequestController etc.)
 * passa a resolver o tenant certo automaticamente, sem precisar tocar em
 * cada um deles individualmente.
 *
 * O papel (role) do usuário nunca é alterado — um admin continua admin
 * (RoleMiddleware ainda dá bypass normal pra ele), só o "de quem é o site
 * que ele está vendo" muda.
 */
class ImpersonateClient
{
    public function handle(Request $request, Closure $next)
    {
        $clientId = session('impersonate_client_id');
        $user = auth()->user();

        if ($clientId && $user && in_array($user->role, ['admin', 'support'], true)) {
            $user->client_id = $clientId;
            $user->unsetRelation('client');
        }

        return $next($request);
    }
}
