<?php

namespace App\Http\Controllers\Suporte;

use App\Http\Controllers\Controller;
use App\Models\PublicationRequest;
use App\Models\Client;

class InicioController extends Controller
{
    /**
     * Painel inicial do suporte: indicadores rápidos.
     */
    public function index()
    {
        $open = PublicationRequest::whereIn('status', PublicationRequest::OPEN_STATUSES);

        $stats = [
            'total_abertas'      => (clone $open)->count(),
            'aguardando_suporte' => PublicationRequest::where('status', 'requested')->count(),
            'dns_pendente'       => PublicationRequest::where('status', 'dns_pending')->count(),
            'aguardando_cliente' => PublicationRequest::where('status', 'awaiting_client_info')->count(),
            'publicadas_hoje'    => PublicationRequest::where('status', 'published')
                ->whereDate('updated_at', today())
                ->count(),
        ];

        $recentes = PublicationRequest::with(['site.client', 'assignee'])
            ->orderByDesc('updated_at')
            ->limit(10)
            ->get();

        return view('backoffice.suporte.inicio', [
            'stats'    => $stats,
            'recentes' => $recentes,
            'area'     => 'suporte',
            'page'     => 'inicio',
        ]);
    }
}
