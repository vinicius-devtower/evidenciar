<?php
namespace App\Services;

use App\Models\Site;

class SiteBuilderService
{
    public function build(Site $site): string
    {
        $templateVersion = $site->templateVersion;

        $viewPath = 'templates::'
            . str_replace('/', '.', $templateVersion->path)
            . '.views.index';

        return view($viewPath, [
            'site' => $site,
            'content' => $site->content ?? [],
        ])->render();
    }
}