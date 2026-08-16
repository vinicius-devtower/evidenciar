@extends('layouts.backoffice')
@section('title', 'Exceções — Logs')

@section('content')
    <h1 class="page-title">Exceções da aplicação</h1>
    <p class="page-sub">
        Cada erro 500 ou exceção não tratada é registrada aqui com um código estável
        (<code>EVD-XXXXXX</code>). Erros iguais originados do mesmo ponto do código compartilham o mesmo código.
    </p>

    {{-- Filtros --}}
    <form method="GET" class="bo-card p-3 mb-3">
        <div class="row g-2">
            <div class="col-md-3">
                <label class="form-label small text-muted">Código</label>
                <input type="text" name="code" value="{{ $filters['code'] }}"
                       class="form-control form-control-sm" placeholder="EVD-AB12CD" list="code-list">
                <datalist id="code-list">
                    @foreach ($codes as $c) <option value="{{ $c }}"></option> @endforeach
                </datalist>
            </div>
            <div class="col-md-2">
                <label class="form-label small text-muted">Severidade</label>
                <select name="severity" class="form-select form-select-sm">
                    <option value="">Todas</option>
                    @foreach (['debug','info','notice','warning','error','critical','alert','emergency'] as $s)
                        <option value="{{ $s }}" @selected($filters['severity'] === $s)>{{ ucfirst($s) }}</option>
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
            <div class="col-md-3">
                <label class="form-label small text-muted">Buscar (mensagem/URL/classe)</label>
                <input type="text" name="q" value="{{ $filters['search'] }}" class="form-control form-control-sm">
            </div>
        </div>
        <div class="mt-2">
            <button class="btn btn-sm btn-dark" type="submit">Filtrar</button>
            <a href="{{ route('suporte.logs.excecoes.index') }}" class="btn btn-sm btn-outline-secondary">Limpar</a>
        </div>
    </form>

    {{-- Listagem --}}
    <div class="bo-card">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th style="width:160px;">Quando</th>
                        <th style="width:120px;">Código</th>
                        <th style="width:90px;">Severidade</th>
                        <th>Mensagem</th>
                        <th style="width:160px;">URL / Rota</th>
                        <th style="width:120px;">Usuário</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($logs as $l)
                        <tr>
                            <td style="font-size:13px;">{{ $l->occurred_at->format('d/m/Y H:i:s') }}</td>
                            <td><code>{{ $l->code }}</code></td>
                            <td>
                                @php
                                    $tone = match($l->severity) {
                                        'critical','alert','emergency' => 'danger',
                                        'error'   => 'danger',
                                        'warning' => 'warning',
                                        'notice','info' => 'info',
                                        default => 'secondary',
                                    };
                                @endphp
                                <span class="badge bg-{{ $tone }}">{{ $l->severity }}</span>
                            </td>
                            <td style="font-size:13px; max-width:380px;">
                                <div style="overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                                    {{ \Illuminate\Support\Str::limit($l->message, 140) }}
                                </div>
                                <div style="font-size:11px; color:#999;">{{ class_basename($l->exception_class) }}</div>
                            </td>
                            <td style="font-size:12px; color:#666;">
                                @if ($l->url)
                                    <span title="{{ $l->url }}">
                                        {{ \Illuminate\Support\Str::limit(parse_url($l->url, PHP_URL_PATH) ?? $l->url, 30) }}
                                    </span>
                                @else — @endif
                            </td>
                            <td style="font-size:13px;">{{ $l->user?->name ?? '—' }}</td>
                            <td>
                                <a href="{{ route('suporte.logs.excecoes.show', $l->id) }}"
                                   class="btn btn-sm btn-outline-dark">Detalhes</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-muted py-4">Nenhuma exceção encontrada com esses filtros.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($logs->hasPages())
            <div class="p-3 border-top">
                {{ $logs->links() }}
            </div>
        @endif
    </div>
@endsection
