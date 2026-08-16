<?php

namespace App\Http\Controllers\Financeiro;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\Request;

class AssinaturaController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');

        $subs = Subscription::with(['client', 'site', 'payments' => fn ($q) => $q->orderByDesc('paid_at')])
            ->when($status, fn ($q) => $q->where('status', $status))
            ->orderByDesc('created_at')
            ->paginate(20)
            ->withQueryString();

        return view('backoffice.financeiro.assinaturas.index', [
            'subs'   => $subs,
            'status' => $status,
            'area'   => 'financeiro',
            'page'   => 'assinaturas',
        ]);
    }

    public function show(Subscription $assinatura)
    {
        $assinatura->load([
            'client.users',
            'site.templateVersion.template',
            'payments' => fn ($q) => $q->orderByDesc('paid_at'),
        ]);

        return view('backoffice.financeiro.assinaturas.show', [
            'sub'  => $assinatura,
            'area' => 'financeiro',
            'page' => 'assinaturas',
        ]);
    }
}
