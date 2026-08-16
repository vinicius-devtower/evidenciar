@extends('layouts.backoffice')
@section('title', 'Webhooks — Logs')

@section('content')
    <h1 class="page-title">Webhooks recebidos</h1>
    <p class="page-sub">
        Todo payload externo que chega nos endpoints de webhook (Mercado Pago, etc.).
        Inclui tanto os que foram processados quanto os ignorados (test pings, eventos não-pagamento).
    </p>

    <form method="GET" class="bo-card p-3 mb-3">
        <div class="row g-2">
            <div class="col-md-3">
                <label class="form-label small text-muted">Provider</label>
                <select name="provider" class="form-select form-select-sm">
                    <option value="">Todos</option>
                    @foreach ($providers as $p)
                        <option value="{{ $p }}" @selected($filters['provider'] === $p)>{{ $p }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small text-muted">Evento</label>
                <select name="event" class="form-select form-select-sm">
                    <option value="">Todos</option>
                    @foreach ($events as $e)
                        <option value="{{ $e }}" @selected($filters['event'] === $e)>{{ $e }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small text-muted">De</label>
                <input type="date" name="from" value="{{ $filters['from'] }}" class="form-control form-control-sm">
            </div>
            <div class="col-md-2">
                <label class="form-label small text-muted">Até</label>
                <input type="date" name="to" value="{{ $filters['to'] }}" class="form-control form-control-sm">
            </div>
        </div>
        <div class="mt-2">
            <button class="btn btn-sm btn-dark" type="submit">Filtrar</button>
            <a href="{{ route('suporte.logs.webhooks.index') }}" class="btn btn-sm btn-outline-secondary">Limpar</a>
        </div>
    </form>

    <div class="bo-card">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th style="width:160px;">Quando</th>
                        <th style="width:140px;">Provider</th>
                        <th style="width:140px;">Evento</th>
                        <th>Resumo do payload</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($logs as $l)
                        <tr>
                            <td style="font-size:13px;">{{ $l->received_at?->format('d/m/Y H:i:s') }}</td>
                            <td><span class="badge bg-secondary">{{ $l->provider }}</span></td>
                            <td style="font-size:13px;">{{ $l->event }}</td>
                            <td style="font-size:12px; color:#666; max-width:400px;">
                                <div style="overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                                    @php
                                        $p = $l->payload;
                                        $summary = is_array($p)
                                            ? implode(', ', array_map(fn ($k, $v) =>
                                                $k . '=' . (is_scalar($v) ? (string) $v : '[…]'),
                                                array_keys($p), array_values($p)))
                                            : (string) $p;
                                    @endphp
                                    {{ \Illuminate\Support\Str::limit($summary, 120) }}
                                </div>
                            </td>
                            <td>
                                <a href="{{ route('suporte.logs.webhooks.show', $l->id) }}"
                                   class="btn btn-sm btn-outline-dark">Detalhes</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted py-4">Nenhum webhook encontrado.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($logs->hasPages())
            <div class="p-3 border-top">{{ $logs->links() }}</div>
        @endif
    </div>
@endsection
