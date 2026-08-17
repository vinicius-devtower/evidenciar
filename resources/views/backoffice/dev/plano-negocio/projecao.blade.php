@extends('layouts.backoffice')
@section('title', 'Plano de Negócio — Projeção Financeira')

@section('content')
    <h1 class="page-title mb-3">Projeção financeira</h1>

    @include('backoffice.dev.plano-negocio._nav')

    <div class="bo-card p-3 mb-4">
        <p class="mb-1">
            Projeção original do plano de negócio: 10 clientes novos/mês, sem perder nenhum
            (fidelidade de 6 meses), plano Start a R$ {{ number_format($precoBase / 100, 2, ',', '.') }}/mês,
            custo fixo de R$ {{ number_format(\App\Http\Controllers\Dev\PlanoNegocioController::CUSTO_FIXO_CENTS / 100, 2, ',', '.') }}/mês.
        </p>
        <p class="text-muted small mb-0">
            A coluna "Real" só aparece nos meses em que alguém preencheu o indicador em
            <a href="{{ route('dev.plano-negocio.indicadores') }}">Indicadores</a>.
        </p>
    </div>

    <div class="bo-card">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Mês</th>
                        <th>Clientes (projetado)</th>
                        <th>Faturamento (projetado)</th>
                        <th>Custo fixo</th>
                        <th>Saldo (projetado)</th>
                        <th>Clientes novos (real)</th>
                    </tr>
                </thead>
                <tbody>
                    @php($mesesReais = $metrics->values())
                    @foreach ($linhas as $i => $l)
                        @php
                            $saldoPositivo = $l['saldo_cents'] >= 0;
                            $real = $mesesReais->get($i);
                        @endphp
                        <tr>
                            <td><strong>Mês {{ $l['mes'] }}</strong></td>
                            <td>{{ $l['clientes'] }}</td>
                            <td>R$ {{ number_format($l['faturamento_cents'] / 100, 2, ',', '.') }}</td>
                            <td>R$ {{ number_format($l['custo_cents'] / 100, 2, ',', '.') }}</td>
                            <td class="{{ $saldoPositivo ? 'text-success' : 'text-danger' }} fw-bold">
                                {{ $saldoPositivo ? '+' : '' }}R$ {{ number_format($l['saldo_cents'] / 100, 2, ',', '.') }}
                                @if ($l['mes'] === 7 || $l['mes'] === 8)
                                    <span class="badge bg-secondary">{{ $l['mes'] === 7 ? 'Empate projetado' : 'Lucro projetado' }}</span>
                                @endif
                            </td>
                            <td>
                                @if ($real)
                                    {{ $real->new_clients ?? '—' }} <span class="text-muted small">({{ $real->month->format('m/Y') }})</span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="bo-card p-3 mt-4">
        <h6>Análise crítica do plano original</h6>
        <ul class="small">
            <li>Você opera "no vermelho" até o mês 7 — precisa de ~R$10.500 a R$12.000 em
                caixa pra cobrir dev + infra enquanto a base cresce.</li>
            <li>Esse custo fixo cobre DEV e infra, <strong>não</strong> inclui gasto com
                anúncios — se pagar tráfego pago, o tempo até o lucro aumenta.</li>
            <li>Estratégia original: focar em venda direta (networking, cold outreach) pra
                não gastar com anúncios no início — ver
                <a href="{{ route('dev.plano-negocio.estrategias') }}">Estratégias de venda</a>.</li>
            <li>Se 30% dos clientes fecharem o plano anual em vez do mensal, o prejuízo do
                mês 1 cai praticamente pela metade — antecipa caixa.</li>
        </ul>
    </div>
@endsection
