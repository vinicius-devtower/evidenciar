<?php

namespace App\Http\Controllers\Dev;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Plan;
use App\Models\Template;
use App\Models\TemplateVersion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class TemplateController extends Controller
{
    /**
     * Lista templates + todas as versões, com flag de ativa.
     */
    public function index()
    {
        $templates = Template::with([
            'versions' => fn ($q) => $q->orderByDesc('id'),
            'plans',
        ])->orderBy('name')->get();

        $plans = Plan::orderBy('name')->get();

        return view('backoffice.dev.templates.index', [
            'templates' => $templates,
            'plans'     => $plans,
            'area'      => 'dev',
            'page'      => 'templates',
        ]);
    }

    public function show(Template $template)
    {
        $template->load(['versions', 'plans']);

        // Ler o template.json da versão ativa para inspeção rápida
        $preview = null;
        $active = $template->versions->firstWhere('is_active', true);
        if ($active && $active->path) {
            $path = resource_path('templates/' . $active->path . '/template.json');
            if (File::exists($path)) {
                $preview = json_decode(File::get($path), true);
            }
        }

        return view('backoffice.dev.templates.show', [
            'template' => $template,
            'preview'  => $preview,
            'plans'    => Plan::orderBy('name')->get(),
            'area'     => 'dev',
            'page'     => 'templates',
        ]);
    }

    /**
     * Torna uma versão ativa (e desativa as demais do mesmo template).
     */
    public function activateVersion(Template $template, TemplateVersion $version)
    {
        abort_unless($version->template_id === $template->id, 404);

        DB::transaction(function () use ($template, $version) {
            TemplateVersion::where('template_id', $template->id)
                ->update(['is_active' => false]);
            $version->update(['is_active' => true]);
        });

        ActivityLog::record(
            event:      'template.version_activated',
            description: "Versão {$version->version} ativada para template {$template->name}",
            subject:    $template,
            user:       auth()->user(),
        );

        return back()->with('success', 'Versão ativada.');
    }

    /**
     * Atribui os planos em que esse template está disponível.
     */
    public function syncPlans(Request $request, Template $template)
    {
        $data = $request->validate([
            'plan_ids'   => ['nullable', 'array'],
            'plan_ids.*' => ['integer', 'exists:plans,id'],
        ]);

        $template->plans()->sync($data['plan_ids'] ?? []);

        ActivityLog::record(
            event:      'template.plans_synced',
            description: 'Planos do template atualizados',
            subject:    $template,
            user:       auth()->user(),
        );

        return back()->with('success', 'Planos atualizados.');
    }
}
