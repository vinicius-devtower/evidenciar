@extends('layouts.backoffice')
@section('title', 'E-mails — Logs')

@section('content')
    <h1 class="page-title">E-mails enviados</h1>
    <p class="page-sub">
        Cada e-mail disparado pela aplicação (welcome, confirmações, notificações). O status é atualizado
        conforme os eventos <code>MessageSending</code> / <code>MessageSent</code> do Symfony Mailer.
    </p>

    <form method="GET" class="bo-card p-3 mb-3">
        <div class="row g-2">
            <div class="col-md-3">
                <label class="form-label small text-muted">Destinatário</label>
                <input type="text" name="to" value="{{ $filters['to'] }}"
                       class="form-control form-control-sm" placeholder="usuario@dominio.com">
            </div>
            <div class="col-md-2">
                <label class="form-label small text-muted">Status</label>
                <select name="status" class="form-select form-select-sm">
                    <option value="">Todos</option>
                    @foreach (['sending','sent','failed'] as $s)
                        <option value="{{ $s }}" @selected($filters['status'] === $s)>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small text-muted">De</label>
                <input type="date" name="from" value="{{ $filters['from'] }}" class="form-control form-control-sm">
            </div>
            <div class="col-md-2">
                <label class="form-label small text-muted">Até</label>
                <input type="date" name="until" value="{{ $filters['until'] }}" class="form-control form-control-sm">
            </div>
        </div>
        <div class="mt-2">
            <button class="btn btn-sm btn-dark" type="submit">Filtrar</button>
            <a href="{{ route('suporte.logs.emails.index') }}" class="btn btn-sm btn-outline-secondary">Limpar</a>
        </div>
    </form>

    <div class="bo-card">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th style="width:160px;">Criado em</th>
                        <th style="width:100px;">Status</th>
                        <th>Para</th>
                        <th>Assunto</th>
                        <th style="width:180px;">Mailable</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($logs as $l)
                        <tr>
                            <td style="font-size:13px;">{{ $l->created_at?->format('d/m/Y H:i:s') }}</td>
                            <td>
                                @php
                                    $tone = match($l->status) {
                                        'sent'    => 'success',
                                        'failed'  => 'danger',
                                        'sending' => 'warning',
                                        default   => 'secondary',
                                    };
                                @endphp
                                <span class="badge bg-{{ $tone }}">{{ $l->status }}</span>
                            </td>
                            <td style="font-size:13px;">{{ $l->to }}</td>
                            <td style="font-size:13px;">
                                {{ \Illuminate\Support\Str::limit($l->subject, 60) }}
                            </td>
                            <td style="font-size:12px; color:#666;">
                                {{ $l->mailable_class ? class_basename($l->mailable_class) : '—' }}
                            </td>
                            <td>
                                <a href="{{ route('suporte.logs.emails.show', $l->id) }}"
                                   class="btn btn-sm btn-outline-dark">Detalhes</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">Nenhum e-mail encontrado.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($logs->hasPages())
            <div class="p-3 border-top">{{ $logs->links() }}</div>
        @endif
    </div>
@endsection
