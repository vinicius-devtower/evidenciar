<?php

namespace App\Http\Controllers\Dev;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TemplatePadraoController extends Controller
{
    /**
     * Lista os 3 templates padrão (one-page, multi-page, site+blog).
     */
    public function index()
    {
        $briefings = config('template_briefings');
        $blocks = config('template_blocks');

        $cards = [];
        foreach ($briefings as $slug => $b) {
            $allBlocks = collect($b['pages'])->pluck('blocks')->flatten()->unique();
            $cards[] = [
                'slug'        => $slug,
                'name'        => $b['name'],
                'subtitle'    => $b['subtitle'],
                'description' => $b['description'],
                'pages_count' => count($b['pages']),
                'blocks_count'=> $allBlocks->count(),
            ];
        }

        return view('backoffice.dev.templates-padrao.index', [
            'cards'         => $cards,
            'blocks_total'  => count($blocks),
            'area'          => 'dev',
            'page'          => 'templates-padrao',
        ]);
    }

    /**
     * Mostra o briefing completo de um template (wireframes navegáveis).
     */
    public function show(string $slug)
    {
        $briefings = config('template_briefings');
        $blocks    = config('template_blocks');

        if (! isset($briefings[$slug])) {
            throw new NotFoundHttpException("Template padrão '{$slug}' não encontrado.");
        }

        $brief = $briefings[$slug];

        // Resolve cada referência de bloco no array completo do registry.
        // Marca blocos inexistentes para ficarem visíveis na view (defensivo).
        $pages = [];
        foreach ($brief['pages'] as $page) {
            $resolved = [];
            foreach ($page['blocks'] as $blockId) {
                if (isset($blocks[$blockId])) {
                    $resolved[] = ['id' => $blockId] + $blocks[$blockId];
                } else {
                    $resolved[] = [
                        'id'          => $blockId,
                        'name'        => "(bloco ausente: {$blockId})",
                        'description' => 'Esse bloco está referenciado na briefing mas não existe no registry.',
                        'sketch'      => 'missing',
                        'fields'      => [],
                        'images'      => [],
                        'notes'       => [],
                    ];
                }
            }
            $pages[] = [
                'name'        => $page['name'],
                'description' => $page['description'] ?? null,
                'blocks'      => $resolved,
            ];
        }

        return view('backoffice.dev.templates-padrao.show', [
            'slug'  => $slug,
            'brief' => $brief,
            'pages' => $pages,
            'area'  => 'dev',
            'page'  => 'templates-padrao',
        ]);
    }
}
