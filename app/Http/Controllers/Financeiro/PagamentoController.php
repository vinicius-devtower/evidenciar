<?php

namespace App\Http\Controllers\Financeiro;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PagamentoController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');

        $pagamentos = Payment::with(['subscription.client'])
            ->when($status, fn ($q) => $q->where('status', $status))
            ->orderByDesc('paid_at')
            ->paginate(30)
            ->withQueryString();

        return view('backoffice.financeiro.pagamentos.index', [
            'pagamentos' => $pagamentos,
            'status'     => $status,
            'area'       => 'financeiro',
            'page'       => 'pagamentos',
        ]);
    }
}
