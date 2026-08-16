<?php

namespace App\Http\Middleware;

use App\Services\PlanFeatureService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware de feature gating baseado no plano do cliente.
 *
 * Uso em rotas:
 *   Route::get('/eva', ...)->middleware('feature:eva');
 *
 * Se o usuário não tiver a feature, redireciona para /app/conta com
 * uma mensagem amigável que convida ao upgrade.
 */
class CheckPlanFeature
{
    public function __construct(protected PlanFeatureService $features)
    {
    }

    public function handle(Request $request, Closure $next, string $feature): Response
    {
        $user = $request->user();

        if ($this->features->userHas($user, $feature)) {
            return $next($request);
        }

        $msg = match ($feature) {
            'eva'              => 'A assistente EVA está disponível nos planos Profissional e Gestão VIP.',
            'blog'             => 'O módulo de blog está disponível apenas no plano Gestão VIP.',
            'pro_email'        => 'O e-mail profissional está disponível apenas no plano Gestão VIP.',
            'multipage'        => 'Mais páginas/seções disponíveis nos planos Profissional e Gestão VIP.',
            'priority_support' => 'Suporte prioritário disponível nos planos Profissional e Gestão VIP.',
            'vip_support'      => 'Atendimento VIP exclusivo do plano Gestão VIP.',
            default            => 'Esta funcionalidade não está disponível no seu plano atual.',
        };

        if ($request->expectsJson()) {
            return response()->json([
                'error'   => 'feature_not_available',
                'feature' => $feature,
                'message' => $msg,
            ], 403);
        }

        return redirect()
            ->route('app.conta')
            ->with('warning', $msg . ' Para liberar, faça o upgrade do seu plano.');
    }
}
