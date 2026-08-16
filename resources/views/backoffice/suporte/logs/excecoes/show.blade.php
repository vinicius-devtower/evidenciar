@extends('layouts.backoffice')
@section('title', 'Exceção ' . $log->code . ' — Logs')

@section('content')
    <div class="d-flex justify-content-between align-items-start mb-3">
        <div>
            <h1 class="page-title mb-1">
                <code>{{ $log->code }}</code>
                @php
                    $tone = match($log->severity) {
                        'critical','alert','emergency','error' => 'danger',
                        'warning' => 'warning',
                        default => 'secondary',
                    };
                @endphp
                <span class="badge bg-{{ $tone }}">{{ $log->severity }}</span>
            </h1>
            <p class="page-sub">
                {{ $log->exception_class }} em
                <code>{{ $log->file }}:{{ $log->line }}</code>
            </p>
        </div>
        <div class="text-end">
            <div style="font-size:12px; color:#999;">Ocorreu em</div>
            <div style="font-size:16px; font-weight:600;">{{ $log->occurred_at->format('d/m/Y H:i:s') }}</div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-8">

            <div class="bo-card mb-3">
                <div class="card-header">Mensagem</div>
                <div class="p-3">
                    <pre style="white-space:pre-wrap; font-family:inherit; margin:0;">{{ $log->message }}</pre>
                </div>
            </div>

            <div class="bo-card mb-3">
                <div class="card-header">Stack trace</div>
                <div class="p-3">
                    @include('backoffice.suporte.logs.partials._json', ['data' => $log->trace])
                </div>
            </div>

            @if (!empty($log->request_payload))
                <div class="bo-card mb-3">
                    <div class="card-header">Request payload</div>
                    <div class="p-3">
                        @include('backoffice.suporte.logs.partials._json', ['data' => $log->request_payload])
                    </div>
                </div>
            @endif

            @if (!empty($log->context))
                <div class="bo-card mb-3">
                    <div class="card-header">Contexto</div>
                    <div class="p-3">
                        @include('backoffice.suporte.logs.partials._json', ['data' => $log->context])
                    </div>
                </div>
            @endif

        </div>

        <div class="col-md-4">

            <div class="bo-card mb-3">
                <div class="card-header">Detalhes</div>
                <div class="p-3" style="font-size:13px;">
                    <div class="mb-2"><strong>URL</strong><br>
                        <span style="word-break:break-all;">{{ $log->url ?? '—' }}</span>
                    </div>
                    <div class="mb-2"><strong>Método</strong><br>{{ $log->method ?? '—' }}</div>
                    <div class="mb-2"><strong>Usuário</strong><br>
                        @if ($log->user)
                            {{ $log->user->name }} <small class="text-muted">({{ $log->user->email }})</small>
                        @else — @endif
                    </div>
                    <div class="mb-2"><strong>IP</strong><br>{{ $log->context['ip'] ?? '—' }}</div>
                    <div class="mb-2"><strong>Rota</strong><br>{{ $log->context['route'] ?? '—' }}</div>
                </div>
            </div>

            <div class="bo-card">
                <div class="card-header">
                    Ocorrências do mesmo código (30d)
                </div>
                <div class="p-2">
                    @forelse ($similares as $s)
                        <a href="{{ route('suporte.logs.excecoes.show', $s->id) }}"
                           style="display:block; padding:8px 10px; border-radius:4px; text-decoration:none; color:#333; font-size:13px;">
                            <div>{{ $s->occurred_at->format('d/m/Y H:i') }}</div>
                            <div style="font-size:11px; color:#999;">
                                {{ \Illuminate\Support\Str::limit($s->message, 60) }}
                            </div>
                        </a>
                    @empty
                        <div class="text-center text-muted py-3" style="font-size:13px;">
                            Essa é a única ocorrência recente.
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('suporte.logs.excecoes.index') }}" class="btn btn-sm btn-outline-secondary">
            ← Voltar para a lista
        </a>
        <a href="{{ route('suporte.logs.excecoes.index', ['code' => $log->code]) }}"
           class="btn btn-sm btn-outline-dark">
            Todas as ocorrências de {{ $log->code }}
        </a>
    </div>
@endsection
