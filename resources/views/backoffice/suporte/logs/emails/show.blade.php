@extends('layouts.backoffice')
@section('title', 'E-mail #' . $log->id . ' — Logs')

@section('content')
    @php
        $tone = match($log->status) {
            'sent'    => 'success',
            'failed'  => 'danger',
            'sending' => 'warning',
            default   => 'secondary',
        };
    @endphp

    <div class="d-flex justify-content-between align-items-start mb-3">
        <div>
            <h1 class="page-title mb-1">
                E-mail #{{ $log->id }}
                <span class="badge bg-{{ $tone }}">{{ $log->status }}</span>
            </h1>
            <p class="page-sub">
                {{ $log->subject }}
            </p>
        </div>
        <div class="text-end">
            <div style="font-size:12px; color:#999;">Criado em</div>
            <div style="font-size:16px; font-weight:600;">{{ $log->created_at?->format('d/m/Y H:i:s') }}</div>
            @if ($log->sent_at)
                <div style="font-size:12px; color:#999; margin-top:4px;">Enviado em</div>
                <div style="font-size:13px;">{{ $log->sent_at->format('d/m/Y H:i:s') }}</div>
            @endif
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-8">

            @if ($log->error)
                <div class="bo-card mb-3">
                    <div class="card-header text-danger">Erro</div>
                    <div class="p-3">
                        <pre style="white-space:pre-wrap; font-family:inherit; margin:0;">{{ $log->error }}</pre>
                    </div>
                </div>
            @endif

            @if (!empty($log->meta))
                <div class="bo-card mb-3">
                    <div class="card-header">Metadados do Mailable</div>
                    <div class="p-3">
                        @include('backoffice.suporte.logs.partials._json', ['data' => $log->meta])
                    </div>
                </div>
            @endif

        </div>
        <div class="col-md-4">
            <div class="bo-card">
                <div class="card-header">Detalhes</div>
                <div class="p-3" style="font-size:13px;">
                    <div class="mb-2"><strong>Para</strong><br>{{ $log->to }}</div>
                    <div class="mb-2"><strong>Assunto</strong><br>{{ $log->subject }}</div>
                    <div class="mb-2"><strong>Mailable</strong><br>
                        <code style="font-size:11px;">{{ $log->mailable_class ?? '—' }}</code>
                    </div>
                    <div class="mb-2"><strong>Usuário</strong><br>
                        @if ($log->user)
                            {{ $log->user->name }}
                            <small class="text-muted d-block">{{ $log->user->email }}</small>
                        @else — @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('suporte.logs.emails.index') }}" class="btn btn-sm btn-outline-secondary">
            ← Voltar para a lista
        </a>
    </div>
@endsection
