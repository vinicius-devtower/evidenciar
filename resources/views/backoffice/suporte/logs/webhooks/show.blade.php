@extends('layouts.backoffice')
@section('title', 'Webhook #' . $log->id . ' — Logs')

@section('content')
    <div class="d-flex justify-content-between align-items-start mb-3">
        <div>
            <h1 class="page-title mb-1">
                Webhook #{{ $log->id }}
                <span class="badge bg-secondary">{{ $log->provider }}</span>
                <span class="badge bg-info">{{ $log->event }}</span>
            </h1>
            <p class="page-sub">
                Recebido em <strong>{{ $log->received_at?->format('d/m/Y H:i:s') }}</strong>
            </p>
        </div>
    </div>

    <div class="bo-card">
        <div class="card-header">Payload completo</div>
        <div class="p-3">
            @include('backoffice.suporte.logs.partials._json', ['data' => $log->payload])
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('suporte.logs.webhooks.index') }}" class="btn btn-sm btn-outline-secondary">
            ← Voltar para a lista
        </a>
    </div>
@endsection
