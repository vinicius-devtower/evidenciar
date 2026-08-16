@php
    $di = $pub->domain_info ?? [];
    $steps = [
        'requested'            => ['Solicitado',           25],
        'in_progress'          => ['Em atendimento',       45],
        'awaiting_client_info' => ['Aguardando seus dados',45],
        'dns_pending'          => ['Configurando DNS',     70],
        'ready_to_publish'     => ['Pronto para ir ao ar', 90],
        'published'            => ['Publicado',           100],
        'rejected'             => ['Recusado',            100],
        'cancelled'            => ['Cancelado',           100],
    ];
    [$stepLabel, $pct] = $steps[$pub->status] ?? [$pub->statusLabel(), 0];
    $tone = match ($pub->status) {
        'published'      => '#21883a',
        'rejected'       => '#c53030',
        'cancelled'      => '#888',
        'awaiting_client_info' => '#b88100',
        default          => '#1a1a1a',
    };
@endphp

<div class="row g-3">
    <div class="col-md-8">
        <div class="bo-card" style="background:#fff; border:1px solid #e5e5e0; border-radius:6px;">
            <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small">Solicitação #{{ $pub->id }}</div>
                    <h5 class="mb-0" style="color:{{ $tone }};">{{ $stepLabel }}</h5>
                </div>
                @if ($pub->isOpen())
                    <form method="POST" action="{{ route('app.publicacao.cancel', $pub) }}"
                          onsubmit="return confirm('Cancelar esta solicitação?');">
                        @csrf
                        <button class="btn btn-sm btn-outline-danger">Cancelar solicitação</button>
                    </form>
                @endif
            </div>

            <div class="p-3 border-bottom">
                <div class="progress" style="height:6px; background:#f1efe6;">
                    <div class="progress-bar" role="progressbar"
                         style="width: {{ $pct }}%; background:{{ $tone }};"></div>
                </div>
                <div class="small text-muted mt-2">
                    Atualizado {{ optional($pub->last_status_at ?? $pub->updated_at)->diffForHumans() }}
                    @if ($pub->assignee)
                        · Responsável: <strong>{{ $pub->assignee->name }}</strong>
                    @endif
                </div>
            </div>

            {{-- Thread --}}
            <div class="p-3" style="max-height:420px; overflow-y:auto;">
                <h6 class="small text-muted text-uppercase mb-3">Conversa com o suporte</h6>
                @forelse ($pub->messages as $m)
                    @php $fromClient = $m->author_role === 'client'; @endphp
                    <div class="mb-3 d-flex {{ $fromClient ? 'justify-content-end' : '' }}">
                        <div style="max-width:75%; background:{{ $fromClient ? '#1a1a1a' : '#fafaf7' }};
                                    color:{{ $fromClient ? '#fff' : '#222' }};
                                    border:1px solid #e5e5e0; border-radius:8px; padding:10px 12px;">
                            <div style="font-size:11px; opacity:.8; margin-bottom:4px;">
                                <strong>{{ $fromClient ? 'Você' : ($m->user->name ?? 'Suporte') }}</strong>
                                · {{ $m->created_at->format('d/m H:i') }}
                            </div>
                            <div style="white-space:pre-line; font-size:14px;">{{ $m->body }}</div>
                        </div>
                    </div>
                @empty
                    <div class="text-muted small text-center py-3">
                        Nenhuma mensagem ainda. Use o campo abaixo para enviar dúvidas ao suporte.
                    </div>
                @endforelse
            </div>

            @if ($pub->isOpen())
                <div class="p-3 border-top">
                    <form method="POST" action="{{ route('app.publicacao.message', $pub) }}">
                        @csrf
                        <textarea name="body" rows="3" class="form-control mb-2" required
                                  placeholder="Escreva para o time de suporte..."></textarea>
                        <div class="text-end">
                            <button class="btn btn-sm btn-dark">Enviar mensagem</button>
                        </div>
                    </form>
                </div>
            @endif
        </div>
    </div>

    <div class="col-md-4">
        <div class="bo-card p-3" style="background:#fff; border:1px solid #e5e5e0; border-radius:6px;">
            <h6 class="small text-muted text-uppercase mb-2">Domínio informado</h6>
            @if (($di['has_domain'] ?? null) === 'yes')
                <div class="small"><span class="text-muted">Domínio:</span> <strong>{{ $di['domain_name'] ?? '—' }}</strong></div>
                <div class="small"><span class="text-muted">Registrador:</span> {{ $di['registrar'] ?? '—' }}</div>
            @elseif (($di['has_domain'] ?? null) === 'no')
                <div class="small"><span class="text-muted">Desejado:</span> <strong>{{ ($di['desired_domain'] ?? '—').($di['extension'] ?? '') }}</strong></div>
                <div class="small">
                    <span class="text-muted">Pediu ajuda:</span>
                    {{ ($di['register_help'] ?? '') === 'yes' ? 'Sim' : 'Não' }}
                </div>
            @else
                <div class="small text-muted">Sem dados de domínio.</div>
            @endif
        </div>

        @if (!empty($di['dns_target']) || !empty($di['dns_verified']))
            <div class="bo-card p-3 mt-3" style="background:#fff; border:1px solid #e5e5e0; border-radius:6px;">
                <h6 class="small text-muted text-uppercase mb-2">Apontamento DNS</h6>
                @php $dns = $di['dns_target'] ?? []; @endphp
                @if (!empty($dns))
                    <div class="small"><span class="text-muted">Tipo:</span> <strong>{{ $dns['type'] ?? '—' }}</strong></div>
                    <div class="small"><span class="text-muted">Host:</span> <strong>{{ $dns['host'] ?? '—' }}</strong></div>
                    <div class="small"><span class="text-muted">Valor:</span> <strong>{{ $dns['value'] ?? '—' }}</strong></div>
                    @if (!empty($dns['notes']))
                        <div class="small text-muted mt-2">{{ $dns['notes'] }}</div>
                    @endif
                @endif
                @if (!empty($di['dns_verified']))
                    <div class="mt-2 badge bg-success">DNS verificado</div>
                @endif
            </div>
        @endif
    </div>
</div>
