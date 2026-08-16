@extends('layouts.backoffice')
@section('title', 'Pagamentos')

@section('content')
    <h1 class="page-title">Pagamentos</h1>
    <p class="page-sub">Todos os pagamentos registrados pelos provedores.</p>

    <div class="mb-3 d-flex gap-2">
        @foreach ([null=>'Todos', 'approved'=>'Aprovados', 'pending'=>'Pendentes', 'rejected'=>'Recusados'] as $k => $l)
            <a href="{{ route('financeiro.pagamentos.index', $k ? ['status'=>$k] : []) }}"
               class="btn btn-sm {{ $status === $k ? 'btn-dark' : 'btn-outline-dark' }}">
                {{ $l }}
            </a>
        @endforeach
    </div>

    <div class="bo-card">
        <div class="table-responsive">
            <table class="table align-middle mb-0 small">
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Assinante</th>
                        <th>Assinatura</th>
                        <th>Valor</th>
                        <th>Status</th>
                        <th>Provider</th>
                        <th>External</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pagamentos as $p)
                        <tr>
                            <td>{{ optional($p->paid_at)->format('d/m/Y H:i') ?? '—' }}</td>
                            <td>{{ $p->subscription->client->name ?? '—' }}</td>
                            <td>#{{ $p->subscription_id }}</td>
                            <td>R$ {{ number_format(($p->amount ?? 0)/100, 2, ',', '.') }}</td>
                            <td><span class="badge bg-secondary">{{ $p->status }}</span></td>
                            <td>{{ $p->provider }}</td>
                            <td><code>{{ $p->external_id }}</code></td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-muted py-4">Sem pagamentos.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">{{ $pagamentos->links() }}</div>
@endsection
