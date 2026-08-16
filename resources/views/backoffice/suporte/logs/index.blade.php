@extends('layouts.backoffice')
@section('title', 'Logs — Suporte')

@section('content')
    <h1 class="page-title">Logs do sistema</h1>
    <p class="page-sub">
        Consulta centralizada de exceções, webhooks, atividade humana e e-mails enviados.
        Retenção: últimos 90 dias.
    </p>

    <div class="row g-3 mb-4">
        @php
            $cards = [
                ['label'=>'Exceções 24h',  'value'=>$stats['excecoes_24h'],  'sub'=>$stats['excecoes_7d'].' nos últimos 7 dias', 'icon'=>'bi-exclamation-octagon',  'tone'=>'danger',  'route'=>route('suporte.logs.excecoes.index')],
                ['label'=>'Webhooks 24h',  'value'=>$stats['webhooks_24h'],  'sub'=>$stats['webhooks_7d'].' nos últimos 7 dias', 'icon'=>'bi-broadcast-pin',        'tone'=>'info',    'route'=>route('suporte.logs.webhooks.index')],
                ['label'=>'Atividade 24h', 'value'=>$stats['atividade_24h'], 'sub'=>$stats['atividade_7d'].' nos últimos 7 dias','icon'=>'bi-clock-history',        'tone'=>'',        'route'=>route('suporte.logs.atividade.index')],
                ['label'=>'E-mails 24h',   'value'=>$stats['emails_24h'],    'sub'=>$stats['emails_falhados'].' falhados (total)','icon'=>'bi-envelope',            'tone'=>'success', 'route'=>route('suporte.logs.emails.index')],
            ];
        @endphp
        @foreach ($cards as $c)
            <div class="col-6 col-md-3">
                <a href="{{ $c['route'] }}" style="text-decoration:none; color:inherit;">
                    <div class="bo-stat {{ $c['tone'] ? 'bo-stat--'.$c['tone'] : '' }}">
                        <div class="bo-stat__icon"><i class="bi {{ $c['icon'] }}"></i></div>
                        <div class="bo-stat__body">
                            <div class="bo-stat__label">{{ $c['label'] }}</div>
                            <div class="bo-stat__value">{{ $c['value'] }}</div>
                            <div class="bo-stat__meta">{{ $c['sub'] }}</div>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

    <div class="bo-card mb-4">
        <div class="card-header">
            <span>Códigos de erro com mais ocorrências (últimos 7 dias)</span>
        </div>
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th style="width:130px;">Código</th>
                        <th>Exceção</th>
                        <th>Mensagem</th>
                        <th style="width:90px;" class="text-center">Total</th>
                        <th style="width:160px;">Última ocorrência</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($topCodes as $row)
                        <tr>
                            <td><code>{{ $row->code }}</code></td>
                            <td style="font-size:13px;">{{ class_basename($row->exception_class) }}</td>
                            <td style="font-size:13px; max-width:400px;">
                                <div style="overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                                    {{ \Illuminate\Support\Str::limit($row->message, 120) }}
                                </div>
                            </td>
                            <td class="text-center"><strong>{{ $row->total }}</strong></td>
                            <td style="font-size:13px;">
                                {{ \Illuminate\Support\Carbon::parse($row->last_seen)->format('d/m/Y H:i') }}
                            </td>
                            <td>
                                <a href="{{ route('suporte.logs.excecoes.index', ['code' => $row->code]) }}"
                                   class="btn btn-sm btn-outline-dark">Ver</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">Sem exceções nos últimos 7 dias. 🎉</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
