@extends('layouts.backoffice')
@section('title', 'Suporte — Visão geral')

@section('content')
    <h1 class="page-title">Visão geral do suporte</h1>
    <p class="page-sub">Panorama das solicitações de publicação abertas.</p>

    <div class="row g-3 mb-4">
        @foreach ([
            ['label'=>'Abertas',            'value'=>$stats['total_abertas'],      'icon'=>'bi-inbox',              'tone'=>''],
            ['label'=>'Aguardando suporte', 'value'=>$stats['aguardando_suporte'], 'icon'=>'bi-hourglass-split',    'tone'=>'warning'],
            ['label'=>'DNS pendente',       'value'=>$stats['dns_pendente'],       'icon'=>'bi-globe2',             'tone'=>'info'],
            ['label'=>'Aguardando cliente', 'value'=>$stats['aguardando_cliente'], 'icon'=>'bi-person-raised-hand', 'tone'=>''],
            ['label'=>'Publicadas hoje',    'value'=>$stats['publicadas_hoje'],    'icon'=>'bi-check2-circle',      'tone'=>'success'],
        ] as $card)
            <div class="col-6 col-md">
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
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Atividade recente</span>
            <a href="{{ route('suporte.publicacoes.index') }}" class="btn btn-sm btn-outline-dark">
                Ver fila completa
            </a>
        </div>
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Assinante</th>
                        <th>Site</th>
                        <th>Status</th>
                        <th>Responsável</th>
                        <th>Atualizado</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recentes as $r)
                        <tr>
                            <td>{{ $r->site->client->name ?? '—' }}</td>
                            <td>{{ $r->site->name ?? '—' }}</td>
                            <td><span class="badge bg-secondary">{{ $r->statusLabel() }}</span></td>
                            <td>{{ $r->assignee->name ?? '—' }}</td>
                            <td>{{ $r->updated_at?->format('d/m/Y H:i') }}</td>
                            <td>
                                <a href="{{ route('suporte.publicacoes.show', $r) }}"
                                   class="btn btn-sm btn-outline-primary">Abrir</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">Sem atividade recente.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
