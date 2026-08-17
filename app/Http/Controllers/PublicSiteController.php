<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Illuminate\Http\Request;

class PublicSiteController extends Controller
{
    public function showBySlug(string $slug)
    {
        $site = Site::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();
        return $this->renderSite($site);
    }
    public function showByDomain(Request $request)
    {
        $site = $request->attributes->get('resolvedSite');
        abort_unless($site, 404);
        return $this->renderSite($site);
    }
    protected function renderSite(Site $site)
    {
        $templateVersion = $site->templateVersion;
        abort_unless($templateVersion && $templateVersion->path, 404);
        $viewPath = 'templates::'
            . str_replace('/', '.', $templateVersion->path)
            . '.views.index';
        abort_unless(view()->exists($viewPath), 404);

        // Se ainda não existe HTML compilado (site publicado direto, sem
        // passar pela fila de publicação), gera e persiste uma vez.
        // NUNCA chamar renderSite() de novo aqui: se o build falhar em
        // produzir HTML (ex.: exceção engolida em algum ponto), isso
        // vira recursão infinita e derruba o PHP-FPM por estouro de memória.
        if (!$site->compiled_html) {
            $html = app(\App\Services\SiteBuilderService::class)->build($site);
            $site->compiled_html = $html;
            $site->save();

            return response($html);
        }

        return response($site->compiled_html);
    }
}
