<?php

namespace App\Http\Controllers;

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

        return view('landing.index', [
            'template' => $template,
        ]);
    }
}
