<?php
namespace App\Http\Controllers;
use App\Models\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
class SiteEditorController extends Controller
{
    /**
     * Exibe o editor do site com base no template.json
     */
    public function edit(Site $site)
    {
        // Recupera template e versão associados ao site
        $version = $site->templateVersion;
        if (!$version || !$version->path) {
            abort(422, 'TemplateVersion sem path configurado.');
        }
        // $templatePath = resource_path(
        //     $version->path . '/template.json'
        // );
        $templatePath = resource_path(
            'templates/' . $version->path . '/template.json'
        );
        if (!File::exists($templatePath)) {
            abort(404, 'Arquivo template.json não encontrado.');
        }
        // Lê e decodifica o contrato do template
        $templateConfig = json_decode(
            File::get($templatePath),
            true
        );
        // Conteúdo atual do site (JSON salvo)
        $content = $site->content ?? [];
        $site->load('activityLogs.user');
        return view('sites.edit', [
            'site' => $site,
            'templateConfig' => $templateConfig,
            'content' => $content,
            'activityLogs' => $site->activityLogs,
        ]);
    }
    /**
     * Salva o conteúdo editado do site.
     *
     * Faz MERGE dos novos dados sobre os antigos para preservar chaves
     * especiais (ex: _branding, _contact_global) que são salvas por outros
     * endpoints e não vêm no POST do editor de seções.
     */
    public function update(Request $request, Site $site)
    {
        $posted   = (array) $request->input('content', []);
        $existing = (array) ($site->content ?? []);

        // Preserva chaves globais (iniciam com "_") que não vieram no POST.
        foreach ($existing as $k => $v) {
            if (str_starts_with((string) $k, '_') && !array_key_exists($k, $posted)) {
                $posted[$k] = $v;
            }
        }

        $site->content = $posted;
        $site->save();

        // Redireciona para o novo editor do painel (sistema/editor.blade.php)
        // com fallback para a rota legada caso ela seja usada em outro contexto.
        $target = $request->headers->get('referer');
        if ($target && str_contains($target, '/app/editor')) {
            return redirect()->route('app.editor')->with('success', 'Alterações salvas.');
        }
        return redirect()
            ->route('app.editor')
            ->with('success', 'Alterações salvas.');
    }
}
