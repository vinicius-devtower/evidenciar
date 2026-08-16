@extends('layouts.backoffice')
@section('title', 'Assinaturas')

@section('content')
    <h1 class="page-title">Assinaturas</h1>
    <p class="page-sub">Listagem consolidada.</p>

    <div class="mb-3 d-flex gap-2">
        @foreach ([null=>'Todas', 'active'=>'Ativas', 'past_due'=>'Em atraso', 'cancelled'=>'Canceladas'] as $k => $l)
            <a href="{{ route('financeiro.assinaturas.index', $k ? ['status'=>$k] : []) }}"
               class="btn btn-sm {{ $status === $k ? 'btn-dark' : 'btn-outline-dark' }}">
                {{ $l }}
            </a>
        @endforeach
    </div>

    <div class="bo-card">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Assinante</th>
                        <th>Site</th>
                        <th>Status</th>
                        <th>Início</th>
                        <th>Último pagamento</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($subs as $sub)
                        @php $last = $sub->payments->first(); @endphp
                        <tr>
                            <td>#{{ $sub->id }}</td>
                            <td>{{ $sub->client->name ?? '—' }}</td>
                            <td>{{ $sub->site->name ?? '—' }}</td>
                            <td><span class="badge bg-secondary">{{ $sub->status }}</span></td>
                            <td>{{ optional($sub->started_at)->format('d/m/Y') ?? '—' }}</td>
                            <td>
                                @if ($last)
                                    {{ optional($last->paid_at)->format('d/m/Y') ?? '—' }}
                                    — R$ {{ number_format(($last->amount ?? 0)/100, 2, ',', '.') }}
                                    <small class="text-muted">({{ $last->status }})</small>
                                @else
                                    —
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('financeiro.assinaturas.show', $sub) }}"
                                   class="btn btn-sm btn-outline-primary">Abrir</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-muted py-4">Sem assinaturas.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">{{ $subs->links() }}</div>
@endsection
