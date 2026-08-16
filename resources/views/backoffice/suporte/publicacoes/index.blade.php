@extends('layouts.backoffice')
@section('title', 'Fila de publicações')

@section('content')
    <h1 class="page-title">Fila de publicações</h1>
    <p class="page-sub">Solicitações enviadas pelos assinantes para publicar o site.</p>

    <div class="bo-card mb-3">
        <div class="p-2 d-flex flex-wrap gap-2">
            @php
                $filters = [
                    'open'                 => 'Abertas ('.$counts['open'].')',
                    'requested'            => 'Solicitadas ('.$counts['requested'].')',
                    'in_progress'          => 'Em atendimento ('.$counts['in_progress'].')',
                    'awaiting_client_info' => 'Aguardando cliente ('.$counts['awaiting_client_info'].')',
                    'dns_pending'          => 'DNS pendente ('.$counts['dns_pending'].')',
                    'ready_to_publish'     => 'Pronto p/ publicar ('.$counts['ready_to_publish'].')',
                    'published'            => 'Publicadas ('.$counts['published'].')',
                ];
            @endphp
            @foreach ($filters as $key => $label)
                <a href="{{ route('suporte.publicacoes.index', ['status'=>$key]) }}"
                   class="btn btn-sm {{ $status === $key ? 'btn-dark' : 'btn-outline-dark' }}">
                    {{ $label }}
                </a>
            @endforeach
            <a href="{{ route('suporte.publicacoes.index', ['status'=>'mine']) }}"
               class="btn btn-sm {{ request('status')==='mine' ? 'btn-primary' : 'btn-outline-primary' }}">
                Minhas atribuições
            </a>
        </div>
    </div>

    <div class="bo-card">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Assinante</th>
                        <th>Site</th>
                        <th>Template</th>
                        <th>Domínio</th>
                        <th>Status</th>
                        <th>Responsável</th>
                        <th>Criado</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($requests as $r)
                        <tr>
                            <td>#{{ $r->id }}</td>
                            <td>{{ $r->site->client->name ?? '—' }}</td>
                            <td>{{ $r->site->name ?? '—' }}</td>
                            <td>
                                {{ $r->site->templateVersion->template->name ?? '—' }}
                                @if ($r->site->templateVersion)
                                    <small class="text-muted">v{{ $r->site->templateVersion->version }}</small>
                                @endif
                            </td>
                            <td>
                                @php
                                    $di = $r->domain_info ?? [];
                                    $dom = $di['domain_name'] ?? $di['desired_domain'] ?? null;
                                @endphp
                                {{ $dom ?? '—' }}
                                @if (($di['has_domain'] ?? null) === 'no')
                                    <span class="badge bg-info text-dark" style="font-size:10px;">Novo</span>
                                @endif
                            </td>
                            <td><span class="badge bg-secondary">{{ $r->statusLabel() }}</span></td>
                            <td>{{ $r->assignee->name ?? '—' }}</td>
                            <td>{{ $r->created_at->format('d/m H:i') }}</td>
                            <td>
                                <a href="{{ route('suporte.publicacoes.show', $r) }}"
                                   class="btn btn-sm btn-outline-primary">Abrir</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="9" class="text-center text-muted py-4">Sem solicitações.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $requests->links() }}
    </div>
@endsection
