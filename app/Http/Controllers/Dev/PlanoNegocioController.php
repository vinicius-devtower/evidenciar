<?php

namespace App\Http\Controllers\Dev;

use App\Http\Controllers\Controller;
use App\Models\BusinessMetric;
use App\Models\BusinessPlanAgreement;
use App\Models\Payment;
use App\Models\Plan;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

/**
 * "Estamos no trilho?" — painel que compara a realidade da operação com o
 * que o Plano de Negócios (sócios Vinicius + João, documento de out/2025)
 * projetou. Não substitui o documento original
 * (knowledge/projetos/evidenciar/plano-de-negocios.md na base de
 * conhecimento) — é o resumo vivo, com números de verdade, pra decisão do
 * dia a dia.
 */
class PlanoNegocioController extends Controller
{
    /** Custo fixo mensal assumido no plano de negócios (dev + infra). */
    public const CUSTO_FIXO_CENTS = 350000; // R$3.500,00

    /** Meta de clientes novos por mês. */
    public const META_CLIENTES_MES = 10;

    public function index()
    {
        $activeSubscriptions = Subscription::where('status', 'active')->with('plan')->get();
        $activeClients = $activeSubscriptions->count();
        $mrrCents = $activeSubscriptions->sum(fn ($s) => $s->plan->price_cents ?? 0);

        $startPlan = Plan::where('slug', Plan::SLUG_START)->first();
        $precoBase = $startPlan->price_cents ?? 4990;
        $pontoEquilibrio = $precoBase > 0 ? (int) ceil(self::CUSTO_FIXO_CENTS / $precoBase) : 0;

        $totalFaturado = Payment::where('status', 'paid')->sum('amount'); // já em reais (decimal)

        $mesAtual = Carbon::now()->startOfMonth();
        $novosClientesMes = Subscription::whereBetween('started_at', [$mesAtual, Carbon::now()->endOfMonth()])->count();

        $ultimoIndicador = BusinessMetric::orderByDesc('month')->first();

        return view('backoffice.dev.plano-negocio.index', [
            'area' => 'dev',
            'page' => 'plano-negocio',
            'activeClients' => $activeClients,
            'mrrCents' => $mrrCents,
            'pontoEquilibrio' => $pontoEquilibrio,
            'precoBase' => $precoBase,
            'totalFaturado' => $totalFaturado,
            'novosClientesMes' => $novosClientesMes,
            'metaClientesMes' => self::META_CLIENTES_MES,
            'custoFixoCents' => self::CUSTO_FIXO_CENTS,
            'ultimoIndicador' => $ultimoIndicador,
            'progressoEquilibrio' => $pontoEquilibrio > 0 ? min(100, (int) round(($activeClients / $pontoEquilibrio) * 100)) : 0,
        ]);
    }

    public function indicadores()
    {
        $metrics = BusinessMetric::orderByDesc('month')->get();

        return view('backoffice.dev.plano-negocio.indicadores', [
            'area' => 'dev',
            'page' => 'plano-negocio',
            'metrics' => $metrics,
            'novoIndicador' => new BusinessMetric(['month' => Carbon::now()->startOfMonth()]),
        ]);
    }

    public function storeIndicador(Request $request)
    {
        $data = $this->validateIndicador($request);

        $metric = BusinessMetric::updateOrCreate(
            ['month' => $data['month']],
            $data + ['updated_by' => $request->user()->id]
        );

        return redirect()->route('dev.plano-negocio.indicadores')
            ->with('success', 'Indicador de ' . $metric->month->format('m/Y') . ' salvo.');
    }

    public function updateIndicador(Request $request, BusinessMetric $indicador)
    {
        $data = $this->validateIndicador($request, $indicador->id);
        $indicador->fill($data + ['updated_by' => $request->user()->id])->save();

        return redirect()->route('dev.plano-negocio.indicadores')
            ->with('success', 'Indicador de ' . $indicador->month->format('m/Y') . ' atualizado.');
    }

    protected function validateIndicador(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'month' => ['required', 'date'],
            'new_clients' => ['nullable', 'integer', 'min:0'],
            'active_clients' => ['nullable', 'integer', 'min:0'],
            'mrr_cents' => ['nullable', 'integer', 'min:0'],
            'marketing_spend_cents' => ['nullable', 'integer', 'min:0'],
            'leads_contacted' => ['nullable', 'integer', 'min:0'],
            'meetings_held' => ['nullable', 'integer', 'min:0'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);
    }

    public function projecao()
    {
        $startPlan = Plan::where('slug', Plan::SLUG_START)->first();
        $precoBase = $startPlan->price_cents ?? 4990;

        $linhas = [];
        $acumuladoClientes = 0;
        for ($mes = 1; $mes <= 12; $mes++) {
            $acumuladoClientes += self::META_CLIENTES_MES;
            $faturamento = $acumuladoClientes * $precoBase;
            $saldo = $faturamento - self::CUSTO_FIXO_CENTS;
            $linhas[] = [
                'mes' => $mes,
                'clientes' => $acumuladoClientes,
                'faturamento_cents' => $faturamento,
                'custo_cents' => self::CUSTO_FIXO_CENTS,
                'saldo_cents' => $saldo,
            ];
        }

        $metrics = BusinessMetric::orderBy('month')->get()->keyBy(fn ($m) => $m->month->format('Y-m'));

        return view('backoffice.dev.plano-negocio.projecao', [
            'area' => 'dev',
            'page' => 'plano-negocio',
            'linhas' => $linhas,
            'precoBase' => $precoBase,
            'metrics' => $metrics,
        ]);
    }

    public function estrategias()
    {
        return view('backoffice.dev.plano-negocio.estrategias', [
            'area' => 'dev',
            'page' => 'plano-negocio',
        ]);
    }

    public function contrato()
    {
        $agreements = BusinessPlanAgreement::with('user')
            ->where('version', BusinessPlanAgreement::CURRENT_VERSION)
            ->get()
            ->keyBy('user_id');

        $meuAceite = $agreements->get(auth()->id());

        return view('backoffice.dev.plano-negocio.contrato', [
            'area' => 'dev',
            'page' => 'plano-negocio',
            'agreements' => $agreements,
            'meuAceite' => $meuAceite,
            'version' => BusinessPlanAgreement::CURRENT_VERSION,
        ]);
    }

    public function aceitarContrato(Request $request)
    {
        BusinessPlanAgreement::updateOrCreate(
            ['user_id' => $request->user()->id, 'version' => BusinessPlanAgreement::CURRENT_VERSION],
            ['agreed_at' => now()]
        );

        return redirect()->route('dev.plano-negocio.contrato')
            ->with('success', 'Registrado — você confirmou de acordo com a minuta v' . BusinessPlanAgreement::CURRENT_VERSION . '.');
    }
}
