@extends('layouts.backoffice')
@section('title', 'Assinantes')

@section('content')
    <h1 class="page-title">Assinantes</h1>
    <p class="page-sub">Clientes ativos e seus sites.</p>

    <form method="GET" class="mb-3">
        <div class="input-group" style="max-width:480px;">
            <input type="search" name="q" value="{{ $q }}"
                   class="form-control" placeholder="Buscar por nome, documento ou e-mail">
            <button class="btn btn-dark">Buscar</button>
        </div>
    </form>

    <div class="bo-card">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Assinante</th>
                        <th>Contato</th>
                        <th>Site</th>
                        <th>Assinatura</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($clients as $c)
                        @php
                            $sub = $c->subscriptions->sortByDesc('created_at')->first();
                            $site = $c->sites->sortByDesc('created_at')->first();
                            $u = $c->users->first();
                        @endphp
                        <tr>
                            <td>
                                <strong>{{ $c->name }}</strong><br>
                                <small class="text-muted">{{ $c->document ?? '—' }}</small>
                            </td>
                            <td>
                                @if ($u)
                                    {{ $u->name }}<br>
                                    <small class="text-muted">{{ $u->email }}</small>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>
                                {{ $site?->name ?? '—' }}<br>
                                <small class="text-muted">
                                    {{ $site?->templateVersion?->template?->name ?? '' }}
                                </small>
                            </td>
                            <td>
                                <span class="badge bg-secondary">{{ $sub?->status ?? '—' }}</span>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('suporte.assinantes.show', $c) }}"
                                   class="btn btn-sm btn-outline-primary">Abrir</a>
                                @if (auth()->user()->role === 'admin')
                                    <form method="POST" action="{{ route('suporte.assinantes.impersonate', $c) }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-dark">Acessar como cliente</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted py-4">Sem resultados.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">{{ $clients->links() }}</div>
@endsection
