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
        // return view($viewPath, [
        //     'site'    => $site,
        //     'content' => $site->content ?? [],
        // ]);
        // return response($site->compiled_html);
        if (!$site->compiled_html) {
            return $this->renderSite($site);
        }

        return response($site->compiled_html);
    }
}
