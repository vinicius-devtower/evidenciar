@extends('layouts.backoffice')
@section('title', 'Financeiro — Visão geral')

@section('content')
    <h1 class="page-title">Visão geral — Financeiro</h1>
    <p class="page-sub">Estado das assinaturas e últimos pagamentos.</p>

    <div class="row g-3 mb-4">
        @foreach ([
            ['label'=>'Total de assinaturas', 'value'=>$stats['total_assinaturas'], 'icon'=>'bi-credit-card',       'tone'=>''],
            ['label'=>'Ativas',               'value'=>$stats['ativas'],            'icon'=>'bi-check2-circle',     'tone'=>'success'],
            ['label'=>'Em atraso',            'value'=>$stats['atrasadas'],         'icon'=>'bi-exclamation-circle','tone'=>'warning'],
            ['label'=>'Canceladas',           'value'=>$stats['canceladas'],        'icon'=>'bi-x-circle',          'tone'=>'danger'],
        ] as $card)
            <div class="col-6 col-md-3">
                <div class="bo-stat {{ $card['tone'] ? 'bo-stat--'.$card['tone'] : '' }}">
                    <div class="bo-stat__icon"><i class="bi {{ $card['icon'] }}"></i></div>
                    <div class="bo-stat__body">
                        <div class="bo-stat__label">{{ $card['label'] }}</div>
                        <div class="bo-stat__value">{{ $card['value'] }}</div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="bo-card">
        <div class="card-header d-flex justify-content-between">
            <span>Últimos pagamentos</span>
            <a href="{{ route('financeiro.pagamentos.index') }}" class="btn btn-sm btn-outline-dark">
                Ver todos
            </a>
        </div>
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Assinante</th>
                        <th>Valor</th>
                        <th>Status</th>
                        <th>Provider</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pagamentosUltimos as $p)
                        <tr>
                            <td>{{ optional($p->paid_at)->format('d/m/Y H:i') ?? '—' }}</td>
                            <td>{{ $p->subscription->client->name ?? '—' }}</td>
                            <td>R$ {{ number_format(($p->amount ?? 0)/100, 2, ',', '.') }}</td>
                            <td><span class="badge bg-secondary">{{ $p->status }}</span></td>
                            <td>{{ $p->provider }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted py-4">Nenhum pagamento registrado.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
