<?php

namespace App\Http\Controllers\Financeiro;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\Payment;

class InicioController extends Controller
{
    public function index()
    {
        $totalAssinaturas = Subscription::count();
        $ativas = Subscription::where('status', 'active')->count();
        $atrasadas = Subscription::where('status', 'past_due')->count();
        $canceladas = Subscription::where('status', 'cancelled')->count();

        $pagamentosUltimos = Payment::with('subscription.client')
            ->orderByDesc('paid_at')
            ->limit(10)
            ->get();

        $mrrCentavos = Subscription::query()
            ->join('payments', 'payments.subscription_id', '=', 'subscriptions.id')
            ->where('subscriptions.status', 'active')
            ->where('payments.status', 'approved')
            ->selectRaw('SUM(payments.amount) as total')
            ->value('total') ?? 0;

        return view('backoffice.financeiro.inicio', [
            'stats' => [
                'total_assinaturas' => $totalAssinaturas,
                'ativas'            => $ativas,
                'atrasadas'         => $atrasadas,
                'canceladas'        => $canceladas,
                'mrr'               => $mrrCentavos / 100,
            ],
            'pagamentosUltimos' => $pagamentosUltimos,
            'area'              => 'financeiro',
            'page'              => 'inicio',
        ]);
    }
}
