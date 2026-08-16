<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Template;

class LandingController extends Controller
{
    /**
     * Página pública principal por onde as leads entram.
     * NÃO é um template do SaaS — é a landing institucional.
     */
    public function index()
    {
        // Mantemos $template opcional; a landing em si não depende dele,
        // mas algumas seções/modais herdadas podem referenciar.
        $template = Template::where('status', 'active')
            ->orderByRaw("CASE WHEN slug = 'clean' THEN 0 ELSE 1 END")
            ->first();

        // Planos ativos, keyBy slug — hero/seção de preços/modal comparativo
        // usam isso pra nunca mais mostrar preço hardcoded divergente do
        // que está configurado em /dev/planos.
        $plans = Plan::where('is_active', true)->get()->keyBy('slug');

        return view('landing.index', [
            'template' => $template,
            'plans'    => $plans,
        ]);
    }
}
