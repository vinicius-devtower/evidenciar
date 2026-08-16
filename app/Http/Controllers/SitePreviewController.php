<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Illuminate\Support\Facades\File;

class SitePreviewController extends Controller
{
    /**
     * Renderiza o preview do site
     */
    public function show(Site $site)
    {
        $templateVersion = $site->templateVersion;

        if (!$templateVersion || !$templateVersion->path) {
            abort(422, 'TemplateVersion não configurada para este site.');
        }

        // Caminho do blade do template
        $viewPath = 'templates::'
            . str_replace('/', '.', $templateVersion->path)
            . '.views.index';

        if (!view()->exists($viewPath)) {
            abort(404, 'View de preview do template não encontrada.');
        }

        return view($viewPath, [
            'site' => $site,
            'content' => $site->content ?? [],
        ]);
    }
}
