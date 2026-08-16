@extends('layouts.backoffice')
@section('title', 'Publicação #'.$pub->id)

@section('content')
    @php
        $site   = $pub->site;
        $client = $site?->client;
        $di     = $pub->domain_info ?? [];
        $dns    = $di['dns_target'] ?? [];
        $check  = $pub->checklist ?? [];
    @endphp

    <div class="d-flex align-items-start justify-content-between mb-3">
        <div>
            <a href="{{ route('suporte.publicacoes.index') }}" class="text-muted small text-decoration-none">
                ← voltar para a fila
            </a>
            <h1 class="page-title mb-1">Publicação #{{ $pub->id }}</h1>
            <p class="page-sub mb-0">
                {{ $client?->name ?? '—' }} · {{ $site?->name ?? '—' }}
            </p>
        </div>
        <div class="text-end">
            <div class="mb-2">
                <span class="badge bg-secondary" style="font-size:12px;">{{ $pub->statusLabel() }}</span>
            </div>
            @if ($pub->assignee)
                <small class="text-muted">Responsável: {{ $pub->assignee->name }}</small>
            @else
                <form method="POST" action="{{ route('suporte.publicacoes.assign', $pub) }}">
                    @csrf
                    <button class="btn btn-sm btn-primary">Assumir atendimento</button>
                </form>
            @endif
        </div>
    </div>

    <div class="row g-3">
        {{-- COLUNA ESQUERDA --}}
        <div class="col-md-8">

            {{-- Thread de mensagens --}}
            <div class="bo-card mb-3">
                <div class="card-header">Conversa com o assinante</div>
                <div class="p-3" style="max-height:420px; overflow-y:auto;">
                    @forelse ($pub->messages as $m)
                        @php
                            $isSupport = in_array($m->author_role, ['support','admin','dev','finance'], true);
                        @endphp
                        <div class="mb-3 d-flex {{ $isSupport ? 'justify-content-end' : '' }}">
                            <div style="max-width:75%; background:{{ $isSupport ? '#1a1a1a' : '#fafaf7' }};
                                        color:{{ $isSupport ? '#fff' : '#222' }};
                                        border:1px solid #e5e5e0; border-radius:8px; padding:10px 12px;">
                                <div style="font-size:11px; opacity:.8; margin-bottom:4px;">
                                    <strong>{{ $m->user->name ?? 'Sistema' }}</strong>
                                    · {{ ucfirst($m->author_role) }}
                                    · {{ $m->created_at->format('d/m H:i') }}
                                </div>
                                <div style="white-space:pre-line; font-size:14px;">{{ $m->body }}</div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-muted small py-3">
                            Nenhuma mensagem ainda.
                        </div>
                    @endforelse
                </div>
                <div class="p-3 border-top">
                    <form method="POST" action="{{ route('suporte.publicacoes.message', $pub) }}">
                        @csrf
                        <textarea name="body" rows="3" class="form-control mb-2" required
                                  placeholder="Escreva para o assinante..."></textarea>
                        <div class="d-flex justify-content-between align-items-center">
                            <select name="change_status_to" class="form-select form-select-sm" style="max-width:260px;">
                                <option value="">Manter status</option>
                                @foreach ($statusLabels as $k => $l)
                                    <option value="{{ $k }}">Mudar para: {{ $l }}</option>
                                @endforeach
                            </select>
                            <button class="btn btn-sm btn-dark">Enviar mensagem</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- DNS --}}
            <div class="bo-card mb-3">
                <div class="card-header">Configuração de DNS</div>
                <div class="p-3">
                    <form method="POST" action="{{ route('suporte.publicacoes.dns', $pub) }}">
                        @csrf
                        <div class="row g-2">
                            <div class="col-md-3">
                                <label class="form-label small">Tipo</label>
                                <select name="dns_type" class="form-select form-select-sm">
                                    <option value="">—</option>
                                    @foreach (['A','AAAA','CNAME','TXT'] as $t)
                                        <option value="{{ $t }}"
                                            {{ ($dns['type'] ?? '') === $t ? 'selected' : '' }}>{{ $t }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small">Host</label>
                                <input name="dns_host" value="{{ $dns['host'] ?? '' }}"
                                       class="form-control form-control-sm" placeholder="@ ou www">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small">Valor / destino</label>
                                <input name="dns_value" value="{{ $dns['value'] ?? '' }}"
                                       class="form-control form-control-sm" placeholder="IP ou hostname">
                            </div>
                            <div class="col-12">
                                <label class="form-label small">Observações (opcional)</label>
                                <textarea name="dns_notes" rows="2"
                                          class="form-control form-control-sm">{{ $dns['notes'] ?? '' }}</textarea>
                            </div>
                            <div class="col-12 d-flex justify-content-between align-items-center">
                                <div class="form-check">
                                    <input type="hidden" name="dns_verified" value="0">
                                    <input type="checkbox" id="dnsVerified" name="dns_verified" value="1"
                                        class="form-check-input"
                                        {{ ($di['dns_verified'] ?? false) ? 'checked' : '' }}>
                                    <label for="dnsVerified" class="form-check-label small">
                                        DNS verificado e propagado
                                    </label>
                                </div>
                                <button class="btn btn-sm btn-dark">Salvar DNS</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Transição de status explícita --}}
            <div class="bo-card">
                <div class="card-header">Transicionar status</div>
                <div class="p-3">
                    <form method="POST" action="{{ route('suporte.publicacoes.transition', $pub) }}" class="row g-2">
                        @csrf
                        <div class="col-md-5">
                            <select name="status" class="form-select form-select-sm" required>
                                <option value="">— escolher —</option>
                                @foreach ($statusLabels as $k => $l)
                                    @if ($k !== $pub->status)
                                        <option value="{{ $k }}">{{ $l }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-5">
                            <input name="notes" class="form-control form-control-sm"
                                   placeholder="Notas (opcional)">
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-sm btn-dark w-100">Aplicar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- COLUNA DIREITA --}}
        <div class="col-md-4">

            {{-- Assinante --}}
            <div class="bo-card mb-3">
                <div class="card-header">Assinante</div>
                <div class="p-3 small">
                    <div><strong>{{ $client?->name ?? '—' }}</strong></div>
                    @if ($client?->document)
                        <div class="text-muted">Doc: {{ $client->document }}</div>
                    @endif
                    @foreach (($client?->users ?? []) as $u)
                        <div class="mt-2">
                            {{ $u->name }}<br>
                            <span class="text-muted">{{ $u->email }}</span>
                        </div>
                    @endforeach
                    @if ($client)
                        <a href="{{ route('suporte.assinantes.show', $client) }}"
                           class="btn btn-sm btn-outline-dark mt-2">Abrir assinante</a>
                    @endif
                </div>
            </div>

            {{-- Domínio (dados do wizard) --}}
            <div class="bo-card mb-3">
                <div class="card-header">Domínio informado</div>
                <div class="p-3 small">
                    @if (($di['has_domain'] ?? null) === 'yes')
                        <div><span class="text-muted">Já tem domínio:</span> <strong>{{ $di['domain_name'] ?? '—' }}</strong></div>
                        <div><span class="text-muted">Registrador:</span> {{ $di['registrar'] ?? '—' }}</div>
                    @elseif (($di['has_domain'] ?? null) === 'no')
                        <div><span class="text-muted">Deseja registrar:</span> <strong>{{ $di['desired_domain'] ?? '—' }}{{ $di['extension'] ?? '' }}</strong></div>
                        <div><span class="text-muted">Quer ajuda do suporte:</span> {{ ($di['register_help'] ?? '') === 'yes' ? 'Sim' : 'Não' }}</div>
                    @else
                        <div class="text-muted">Não informado.</div>
                    @endif
                    @if (!empty($di['access_notes']))
                        <div class="mt-2 p-2" style="background:#fafaf7; border-radius:4px;">
                            {{ $di['access_notes'] }}
                        </div>
                    @endif
                </div>
            </div>

            {{-- Checklist --}}
            <div class="bo-card mb-3">
                <div class="card-header">Checklist do cliente</div>
                <div class="p-3 small">
                    @php
                        $items = [
                            'content'  => 'Conteúdo revisado',
                            'images'   => 'Imagens definitivas',
                            'contacts' => 'Contatos preenchidos',
                            'branding' => 'Identidade visual pronta',
                        ];
                    @endphp
                    @foreach ($items as $k => $l)
                        <div>
                            @if (!empty($check[$k]))
                                <span style="color:#21883a;">✓</span>
                            @else
                                <span style="color:#bbb;">○</span>
                            @endif
                            {{ $l }}
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Site --}}
            <div class="bo-card">
                <div class="card-header">Site</div>
                <div class="p-3 small">
                    <div><strong>{{ $site->name }}</strong></div>
                    <div class="text-muted">
                        Template: {{ $site->templateVersion->template->name ?? '—' }}
                        @if ($site->templateVersion)
                            v{{ $site->templateVersion->version }}
                        @endif
                    </div>
                    <div class="text-muted">Status: {{ $site->status }}</div>
                    @if ($site->slug)
                        <a href="{{ route('app.sites.public.show', $site->slug) }}"
                           target="_blank" class="btn btn-sm btn-outline-dark mt-2">
                            Ver preview público
                        </a>
                    @endif
                </div>
            </div>

        </div>
    </div>
@endsection
