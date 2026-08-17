@extends('layouts.backoffice')
@section('title', 'Plano de Negócio — Estamos no trilho?')

@section('content')
    <h1 class="page-title mb-1">Estamos no trilho?</h1>
    <p class="text-muted mb-3">
        Comparação entre a operação real e o que o Plano de Negócio (Vinicius + João, out/2025) projetou.
        Documento completo na knowledge base do projeto:
        <code>knowledge/projetos/evidenciar/plano-de-negocios.md</code>.
    </p>

    @include('backoffice.dev.plano-negocio._nav')

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="bo-card p-3">
                <div class="text-muted small">Clientes ativos hoje</div>
                <div class="fs-3 fw-bold">{{ $activeClients }}</div>
                <div class="text-muted small">Meta: {{ $pontoEquilibrio }} p/ empatar o custo fixo</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="bo-card p-3">
                <div class="text-muted small">MRR estimado (planos ativos)</div>
                <div class="fs-3 fw-bold">R$ {{ number_format($mrrCents / 100, 2, ',', '.') }}</div>
                <div class="text-muted small">Custo fixo: R$ {{ number_format($custoFixoCents / 100, 2, ',', '.') }}/mês</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="bo-card p-3">
                <div class="text-muted small">Novos clientes este mês</div>
                <div class="fs-3 fw-bold">{{ $novosClientesMes }} <span class="fs-6 text-muted">/ meta {{ $metaClientesMes }}</span></div>
                <div class="text-muted small">
                    @if ($novosClientesMes >= $metaClientesMes)
                        <span class="text-success">Meta batida ✅</span>
                    @else
                        Faltam {{ $metaClientesMes - $novosClientesMes }} pra bater a meta
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="bo-card p-3">
                <div class="text-muted small">Faturado desde o início (pago)</div>
                <div class="fs-3 fw-bold">R$ {{ number_format($totalFaturado, 2, ',', '.') }}</div>
                <div class="text-muted small">Soma de todos os pagamentos aprovados</div>
            </div>
        </div>
    </div>

    <div class="bo-card p-3 mb-4">
        <h6 class="mb-2">Rumo ao ponto de equilíbrio</h6>
        <p class="text-muted small mb-2">
            Ponto de equilíbrio = quantos clientes ativos, pagando o plano Start
            (R$ {{ number_format($precoBase / 100, 2, ',', '.') }}/mês), cobrem o custo fixo de
            R$ {{ number_format($custoFixoCents / 100, 2, ',', '.') }}/mês — {{ $pontoEquilibrio }} clientes.
        </p>
        <div class="progress" style="height: 24px;">
            <div class="progress-bar bg-success" role="progressbar"
                 style="width: {{ $progressoEquilibrio }}%;"
                 aria-valuenow="{{ $progressoEquilibrio }}" aria-valuemin="0" aria-valuemax="100">
                {{ $progressoEquilibrio }}%
            </div>
        </div>
        <div class="text-muted small mt-2">{{ $activeClients }} de {{ $pontoEquilibrio }} clientes ativos</div>
    </div>

    @if ($ultimoIndicador)
        <div class="bo-card p-3 mb-4">
            <h6 class="mb-2">Último indicador preenchido — {{ $ultimoIndicador->month->format('m/Y') }}</h6>
            <div class="row g-3">
                <div class="col-md-3">
                    <div class="text-muted small">Clientes novos registrados</div>
                    <div class="fw-bold">{{ $ultimoIndicador->new_clients ?? '—' }}</div>
                </div>
                <div class="col-md-3">
                    <div class="text-muted small">Gasto com marketing</div>
                    <div class="fw-bold">{{ $ultimoIndicador->marketingSpendFormatted() }}</div>
                </div>
                <div class="col-md-3">
                    <div class="text-muted small">Leads abordados</div>
                    <div class="fw-bold">{{ $ultimoIndicador->leads_contacted ?? '—' }}</div>
                </div>
                <div class="col-md-3">
                    <div class="text-muted small">Reuniões feitas</div>
                    <div class="fw-bold">{{ $ultimoIndicador->meetings_held ?? '—' }}</div>
                </div>
            </div>
            <a href="{{ route('dev.plano-negocio.indicadores') }}" class="small">Ver todos os indicadores →</a>
        </div>
    @else
        <div class="alert alert-warning">
            Nenhum indicador mensal preenchido ainda.
            <a href="{{ route('dev.plano-negocio.indicadores') }}">Preencher o primeiro</a>
            (gasto com marketing, leads abordados, reuniões — números que não têm como vir do sistema sozinho).
        </div>
    @endif

    <div class="row g-3">
        <div class="col-md-6">
            <div class="bo-card p-3 h-100">
                <h6><i class="bi bi-graph-up"></i> Projeção financeira</h6>
                <p class="text-muted small">Mês a mês, comparando com o que foi projetado no plano de negócio.</p>
                <a href="{{ route('dev.plano-negocio.projecao') }}" class="btn btn-sm btn-outline-dark">Ver projeção</a>
            </div>
        </div>
        <div class="col-md-6">
            <div class="bo-card p-3 h-100">
                <h6><i class="bi bi-bullseye"></i> Estratégias de venda</h6>
                <p class="text-muted small">Networking, Instagram, e-mail frio, Google Maps — o playbook de custo zero.</p>
                <a href="{{ route('dev.plano-negocio.estrategias') }}" class="btn btn-sm btn-outline-dark">Ver estratégias</a>
            </div>
        </div>
    </div>
@endsection
