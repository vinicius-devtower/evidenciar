<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Site;
use App\Models\Subscription;
use App\Models\Template;
use App\Models\TemplateVersion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;

/**
 * Painel do cliente após login.
 * Renderiza as abas: Visão Geral, Editor do Site, Tutoriais, Conta
 * usando o layout "sistema-static" (layouts.sistema).
 */
class SistemaController extends Controller
{
    /**
     * Visão Geral (dashboard).
     */
    public function inicio()
    {
        $user = Auth::user();
        $client = $user->client;
        $site = $client?->sites()->latest()->first();
        $subscription = $client?->subscriptions()->latest()->first();

        return view('sistema.visao-geral', [
            'user'         => $user,
            'client'       => $client,
            'site'         => $site,
            'subscription' => $subscription,
            'page'         => 'visao-geral',
        ]);
    }

    /**
     * Editor do Site.
     */
    public function editor()
    {
        $user   = Auth::user();
        $client = $user->client;
        $site   = $client?->sites()->latest()->first();

        if (!$site) {
            return redirect()
                ->route('app.templates')
                ->with('error', 'Selecione um template antes de abrir o editor.');
        }

        $version = $site->templateVersion;
        if (!$version || !$version->path) {
            abort(422, 'TemplateVersion sem path configurado.');
        }

        $templatePath = resource_path('templates/' . $version->path . '/template.json');
        if (!File::exists($templatePath)) {
            abort(404, 'template.json não encontrado.');
        }

        $templateConfig = json_decode(File::get($templatePath), true);

        return view('sistema.editor', [
            'user'           => $user,
            'site'           => $site,
            'templateConfig' => $templateConfig,
            'content'        => $site->content ?? [],
            'page'           => 'editor',
        ]);
    }

    /**
     * Tutoriais (conteúdo estático por enquanto).
     */
    public function tutoriais()
    {
        return view('sistema.tutoriais', [
            'page' => 'tutoriais',
        ]);
    }

    /**
     * Biblioteca de templates do cliente.
     */
    public function templates()
    {
        $user   = Auth::user();
        $client = $user->client;
        $site   = $client?->sites()->latest()->first();

        // Templates disponíveis: client_templates ativos
        $templates = $client
            ? $client->templates()
                ->wherePivot('status', 'active')
                ->with(['versions' => fn ($q) => $q->where('is_active', true)])
                ->get()
            : collect();

        $currentTemplateId = $site?->templateVersion?->template_id;

        return view('sistema.templates', [
            'user'              => $user,
            'client'            => $client,
            'site'              => $site,
            'templates'         => $templates,
            'currentTemplateId' => $currentTemplateId,
            'page'              => 'templates',
        ]);
    }

    /**
     * Troca o template do site do cliente.
     */
    public function switchTemplate(Request $request)
    {
        $data = $request->validate([
            'template_id' => ['required', 'integer', 'exists:templates,id'],
        ]);

        $user   = Auth::user();
        $client = $user->client;
        $site   = $client?->sites()->latest()->first();

        if (!$site) {
            return redirect()->route('app.templates')
                ->with('error', 'Você ainda não tem um site para aplicar o template.');
        }

        // Confere se o cliente tem acesso a esse template
        $hasAccess = $client->templates()
            ->wherePivot('status', 'active')
            ->where('templates.id', $data['template_id'])
            ->exists();

        if (!$hasAccess) {
            return redirect()->route('app.templates')
                ->with('error', 'Este template não está disponível no seu plano.');
        }

        // Pega a versão ativa desse template
        $version = TemplateVersion::where('template_id', $data['template_id'])
            ->where('is_active', true)
            ->first();

        if (!$version) {
            return redirect()->route('app.templates')
                ->with('error', 'Nenhuma versão ativa encontrada para este template.');
        }

        $site->update(['template_version_id' => $version->id]);

        ActivityLog::record(
            event:       'site.template_changed',
            description: "Template do site trocado para #{$data['template_id']}",
            subject:     $site,
            user:        $user
        );

        return redirect()->route('app.templates')
            ->with('success', 'Template aplicado com sucesso!');
    }

    /**
     * Salva identidade visual (logos + cores) no site.content['_branding'].
     *
     * Novo shape:
     *   logo_url, logo_alt_url, color_primary, color_contact, color_icons
     * Mantém compatibilidade com shape antigo (primary_color, secondary_color).
     */
    public function saveBranding(Request $request)
    {
        $data = $request->validate([
            'logo_url'      => ['nullable', 'string', 'max:500'],
            'logo_alt_url'  => ['nullable', 'string', 'max:500'],
            'color_primary' => ['nullable', 'string', 'max:20'],
            'color_contact' => ['nullable', 'string', 'max:20'],
            'color_icons'   => ['nullable', 'string', 'max:20'],
            // aliases antigos (continuam aceitos)
            'primary_color'   => ['nullable', 'string', 'max:20'],
            'secondary_color' => ['nullable', 'string', 'max:20'],
        ]);

        $site = Auth::user()->client?->sites()->latest()->first();
        if (!$site) {
            return back()->with('error', 'Site não encontrado.');
        }

        $content = $site->content ?? [];
        $content['_branding'] = array_filter($data, fn ($v) => $v !== null && $v !== '');
        $site->content = $content;
        $site->save();

        return back()->with('success', 'Identidade visual salva.');
    }

    /**
     * Salva contatos globais em site.content['_contact_global'].
     *
     * Novo shape (vem do form como contacts[canal][enabled|value|message]):
     *   [canal => ['enabled' => bool, 'value' => string, 'message' => string?], ...]
     * Mantém compatibilidade com shape antigo (strings soltas).
     */
    public function saveContactGlobal(Request $request)
    {
        $validated = $request->validate([
            'contacts'                      => ['nullable', 'array'],
            'contacts.*.enabled'            => ['nullable', 'in:0,1'],
            'contacts.*.value'              => ['nullable', 'string', 'max:300'],
            'contacts.*.message'            => ['nullable', 'string', 'max:500'],
            // compat com shape antigo (strings soltas):
            'whatsapp'                      => ['nullable', 'string', 'max:50'],
            'email'                         => ['nullable', 'email', 'max:200'],
            'instagram'                     => ['nullable', 'string', 'max:300'],
            'facebook'                      => ['nullable', 'string', 'max:300'],
        ]);

        $site = Auth::user()->client?->sites()->latest()->first();
        if (!$site) {
            return back()->with('error', 'Site não encontrado.');
        }

        $content = $site->content ?? [];

        // Constrói o shape normalizado
        $normalized = [];
        foreach (($validated['contacts'] ?? []) as $channel => $payload) {
            $normalized[$channel] = [
                'enabled' => (string)($payload['enabled'] ?? '0') === '1',
                'value'   => trim((string)($payload['value'] ?? '')),
                'message' => trim((string)($payload['message'] ?? '')),
            ];
            // Limpa vazios sem perder o flag enabled
            if ($normalized[$channel]['message'] === '') {
                unset($normalized[$channel]['message']);
            }
        }

        // Shape antigo → migra para o novo shape se não veio contacts[]
        if (empty($normalized)) {
            foreach (['whatsapp', 'email', 'instagram', 'facebook'] as $k) {
                if (filled($validated[$k] ?? null)) {
                    $normalized[$k] = ['enabled' => true, 'value' => $validated[$k]];
                }
            }
        }

        $content['_contact_global'] = $normalized;
        $site->content = $content;
        $site->save();

        return back()->with('success', 'Informações de contato salvas.');
    }

    /**
     * Conta (dados do user/client/subscription).
     */
    public function conta()
    {
        $user = Auth::user();
        $client = $user->client;
        $subscription = $client?->subscriptions()->latest()->first();

        return view('sistema.conta', [
            'user'         => $user,
            'client'       => $client,
            'subscription' => $subscription,
            'page'         => 'conta',
        ]);
    }
}
