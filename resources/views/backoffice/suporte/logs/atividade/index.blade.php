@extends('layouts.backoffice')
@section('title', 'Atividade — Logs')

@section('content')
    <h1 class="page-title">Atividade do usuário</h1>
    <p class="page-sub">
        Ações humanas registradas via <code>ActivityLog::record()</code> — hoje principalmente edições de site e
        transições de publicação.
    </p>

    <form method="GET" class="bo-card p-3 mb-3">
        <div class="row g-2">
            <div class="col-md-3">
                <label class="form-label small text-muted">Evento</label>
                <select name="event" class="form-select form-select-sm">
                    <option value="">Todos</option>
                    @foreach ($events as $e)
                        <option value="{{ $e }}" @selected($filters['event'] === $e)>{{ $e }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small text-muted">Entidade</label>
                <select name="subject_type" class="form-select form-select-sm">
                    <option value="">Todas</option>
                    @foreach ($subjects as $s)
                        <option value="{{ $s }}" @selected($filters['subject'] === $s)>{{ class_basename($s) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small text-muted">Usuário (id)</label>
                <input type="number" name="user_id" value="{{ $filters['userId'] }}" class="form-control form-control-sm">
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
            <a href="{{ route('suporte.logs.atividade.index') }}" class="btn btn-sm btn-outline-secondary">Limpar</a>
        </div>
    </form>

    <div class="bo-card">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th style="width:160px;">Quando</th>
                        <th style="width:180px;">Evento</th>
                        <th>Descrição</th>
                        <th style="width:180px;">Entidade</th>
                        <th style="width:160px;">Usuário</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($logs as $l)
                        <tr>
                            <td style="font-size:13px;">{{ $l->created_at?->format('d/m/Y H:i:s') }}</td>
                            <td><span class="badge bg-dark">{{ $l->event }}</span></td>
                            <td style="font-size:13px;">
                                {{ \Illuminate\Support\Str::limit($l->description, 140) }}
                            </td>
                            <td style="font-size:12px; color:#666;">
                                {{ class_basename($l->subject_type) }} #{{ $l->subject_id }}
                            </td>
                            <td style="font-size:13px;">{{ $l->user?->name ?? '—' }}</td>
                            <td>
                                <a href="{{ route('suporte.logs.atividade.show', $l->id) }}"
                                   class="btn btn-sm btn-outline-dark">Detalhes</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">Nenhum evento encontrado.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($logs->hasPages())
            <div class="p-3 border-top">{{ $logs->links() }}</div>
        @endif
    </div>
@endsection
