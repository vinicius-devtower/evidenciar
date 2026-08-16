@extends('layouts.backoffice')
@section('title', 'Assinatura #'.$sub->id)

@section('content')
    <a href="{{ route('financeiro.assinaturas.index') }}" class="text-muted small text-decoration-none">
        ← voltar
    </a>
    <h1 class="page-title mb-1">Assinatura #{{ $sub->id }}</h1>
    <p class="page-sub">
        {{ $sub->client->name ?? '—' }}
        · <span class="badge bg-secondary">{{ $sub->status }}</span>
    </p>

    <div class="row g-3">
        <div class="col-md-5">
            <div class="bo-card">
                <div class="card-header">Detalhes</div>
                <div class="p-3 small">
                    <div><strong>Site:</strong> {{ $sub->site->name ?? '—' }}</div>
                    <div><strong>Template:</strong> {{ $sub->site->templateVersion->template->name ?? '—' }}</div>
                    <div><strong>Início:</strong> {{ optional($sub->started_at)->format('d/m/Y') ?? '—' }}</div>
                    <div><strong>Fim:</strong>    {{ optional($sub->ended_at)->format('d/m/Y')   ?? '—' }}</div>
                </div>
            </div>

            <div class="bo-card mt-3">
                <div class="card-header">Contato do assinante</div>
                <div class="p-3 small">
                    @forelse ($sub->client->users as $u)
                        <div>{{ $u->name }} — <span class="text-muted">{{ $u->email }}</span></div>
                    @empty
                        <span class="text-muted">Sem usuários.</span>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="bo-card">
                <div class="card-header">Histórico de pagamentos</div>
                <div class="table-responsive">
                    <table class="table mb-0 small">
                        <thead>
                            <tr>
                                <th>Data</th>
                                <th>Valor</th>
                                <th>Status</th>
                                <th>Provider</th>
                                <th>External ID</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($sub->payments as $p)
                                <tr>
                                    <td>{{ optional($p->paid_at)->format('d/m/Y H:i') ?? '—' }}</td>
                                    <td>R$ {{ number_format(($p->amount ?? 0)/100, 2, ',', '.') }}</td>
                                    <td><span class="badge bg-secondary">{{ $p->status }}</span></td>
                                    <td>{{ $p->provider }}</td>
                                    <td><code>{{ $p->external_id }}</code></td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center text-muted py-3">Sem pagamentos.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
