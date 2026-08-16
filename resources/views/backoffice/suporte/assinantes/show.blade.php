@extends('layouts.backoffice')
@section('title', $client->name)

@section('content')
    <a href="{{ route('suporte.assinantes.index') }}" class="text-muted small text-decoration-none">
        ← voltar para assinantes
    </a>
    <h1 class="page-title mb-1">{{ $client->name }}</h1>
    <p class="page-sub">{{ $client->document ?? '' }}</p>

    <div class="row g-3">
        <div class="col-md-6">
            <div class="bo-card">
                <div class="card-header">Usuários do cliente</div>
                <div class="p-3 small">
                    @forelse ($client->users as $u)
                        <div class="mb-2">
                            <strong>{{ $u->name }}</strong><br>
                            <span class="text-muted">{{ $u->email }}</span>
                        </div>
                    @empty
                        <span class="text-muted">Nenhum usuário vinculado.</span>
                    @endforelse
                </div>
            </div>

            <div class="bo-card mt-3">
                <div class="card-header">Sites</div>
                <div class="p-3 small">
                    @forelse ($client->sites as $s)
                        <div class="mb-2 pb-2 border-bottom">
                            <strong>{{ $s->name }}</strong>
                            <span class="badge bg-secondary">{{ $s->status }}</span><br>
                            <span class="text-muted">
                                Template: {{ $s->templateVersion?->template?->name ?? '—' }}
                                @if ($s->templateVersion) v{{ $s->templateVersion->version }} @endif
                            </span>
                            @if ($s->domain)
                                <br><span class="text-muted">Domínio: {{ $s->domain->domain }} ({{ $s->domain->status }})</span>
                            @endif
                        </div>
                    @empty
                        <span class="text-muted">Sem sites.</span>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="bo-card">
                <div class="card-header">Assinaturas</div>
                <div class="p-3 small">
                    @forelse ($client->subscriptions as $sub)
                        <div class="mb-2 pb-2 border-bottom">
                            #{{ $sub->id }}
                            <span class="badge bg-secondary">{{ $sub->status }}</span><br>
                            <span class="text-muted">
                                Início: {{ optional($sub->started_at)->format('d/m/Y') ?? '—' }}
                                · Fim: {{ optional($sub->ended_at)->format('d/m/Y') ?? '—' }}
                            </span>
                        </div>
                    @empty
                        <span class="text-muted">Nenhuma assinatura.</span>
                    @endforelse
                </div>
            </div>

            <div class="bo-card mt-3">
                <div class="card-header">Solicitações de publicação</div>
                <div class="p-3 small">
                    @php
                        $reqs = $client->sites->flatMap->publicationRequests->sortByDesc('created_at');
                    @endphp
                    @forelse ($reqs as $r)
                        <div class="mb-2 pb-2 border-bottom">
                            #{{ $r->id }}
                            <span class="badge bg-secondary">{{ $r->statusLabel() }}</span><br>
                            <span class="text-muted">Criado {{ $r->created_at->format('d/m/Y H:i') }}</span>
                            <a href="{{ route('suporte.publicacoes.show', $r) }}"
                               class="btn btn-sm btn-outline-dark float-end">Abrir</a>
                        </div>
                    @empty
                        <span class="text-muted">Nenhuma solicitação.</span>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
