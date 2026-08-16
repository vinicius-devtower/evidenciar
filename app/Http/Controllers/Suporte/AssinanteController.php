<?php

namespace App\Http\Controllers\Suporte;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class AssinanteController extends Controller
{
    /**
     * Lista de assinantes (Clients) com filtros simples.
     */
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q'));

        $clients = Client::query()
            ->with(['sites.templateVersion.template', 'subscriptions', 'users'])
            ->when($q, function ($query) use ($q) {
                $query->where(function ($w) use ($q) {
                    $w->where('name', 'like', "%{$q}%")
                      ->orWhere('document', 'like', "%{$q}%")
                      ->orWhereHas('users', function ($u) use ($q) {
                          $u->where('email', 'like', "%{$q}%")
                            ->orWhere('name', 'like', "%{$q}%");
                      });
                });
            })
            ->orderBy('name')
            ->paginate(20)
            ->withQueryString();

        return view('backoffice.suporte.assinantes.index', [
            'clients' => $clients,
            'q'       => $q,
            'area'    => 'suporte',
            'page'    => 'assinantes',
        ]);
    }

    /**
     * Detalhe de um assinante específico (visão do suporte).
     */
    public function show(Client $assinante)
    {
        $assinante->load([
            'users',
            'sites.templateVersion.template',
            'sites.domain',
            'sites.publicationRequests' => fn ($q) => $q->orderByDesc('created_at'),
            'subscriptions' => fn ($q) => $q->orderByDesc('created_at'),
        ]);

        return view('backoffice.suporte.assinantes.show', [
            'client' => $assinante,
            'area'   => 'suporte',
            'page'   => 'assinantes',
        ]);
    }
}
