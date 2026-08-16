@extends('layouts.backoffice')
@section('title', 'Atividade #' . $log->id . ' — Logs')

@section('content')
    <h1 class="page-title">
        <span class="badge bg-dark">{{ $log->event }}</span>
        Atividade #{{ $log->id }}
    </h1>
    <p class="page-sub">Registrado em {{ $log->created_at?->format('d/m/Y H:i:s') }}</p>

    <div class="row g-3">
        <div class="col-md-8">
            <div class="bo-card">
                <div class="card-header">Descrição</div>
                <div class="p-3">
                    <pre style="white-space:pre-wrap; font-family:inherit; margin:0;">{{ $log->description }}</pre>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="bo-card">
                <div class="card-header">Detalhes</div>
                <div class="p-3" style="font-size:13px;">
                    <div class="mb-2"><strong>Entidade</strong><br>
                        {{ class_basename($log->subject_type) }} #{{ $log->subject_id }}
                    </div>
                    <div class="mb-2"><strong>Usuário</strong><br>
                        @if ($log->user)
                            {{ $log->user->name }}
                            <small class="text-muted d-block">{{ $log->user->email }}</small>
                        @else
                            <span class="text-muted">(sistema)</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('suporte.logs.atividade.index') }}" class="btn btn-sm btn-outline-secondary">
            ← Voltar para a lista
        </a>
    </div>
@endsection
