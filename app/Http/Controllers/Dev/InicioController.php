<?php

namespace App\Http\Controllers\Dev;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Site;
use App\Models\Template;
use App\Models\TemplateVersion;

class InicioController extends Controller
{
    public function index()
    {
        $stats = [
            'templates'       => Template::count(),
            'versoes_ativas'  => TemplateVersion::where('is_active', true)->count(),
            'sites'           => Site::count(),
            'planos'          => Plan::count(),
        ];

        $templates = Template::with('versions')->get();

        return view('backoffice.dev.inicio', [
            'stats'     => $stats,
            'templates' => $templates,
            'area'      => 'dev',
            'page'      => 'inicio',
        ]);
    }
}
