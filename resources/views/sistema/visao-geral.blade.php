@extends('layouts.sistema')

@section('title', 'Visão Geral — Evidenciar')

@section('content')
<div class="visao-geral">

    <!-- HEADER -->
    @php
        $meses = [1=>'Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'];
    @endphp
    <div class="vg-header text-center mb-5">
        <h2>Olá, {{ $user->name }}</h2>
        <p>{{ now()->day }} de {{ $meses[now()->month] }} de {{ now()->year }}</p>
    </div>

    @if ($site && $site->status !== 'published')
        @php
            $openPub = $site->publicationRequests()
                ->whereIn('status', \App\Models\PublicationRequest::OPEN_STATUSES)
                ->latest()
                ->first();
        @endphp
        <div class="alert" style="background:#fffaeb; border:1px solid #f3e1a8; border-radius:6px;">
            @if ($openPub)
                <strong>Solicitação de publicação em andamento.</strong>
                Status atual: <em>{{ $openPub->statusLabel() }}</em>.
                <a href="{{ route('app.publicacao.index') }}" class="btn btn-sm btn-dark ms-2">
                    Acompanhar
                </a>
            @else
                <strong>Pronto para publicar?</strong>
                Quando terminar as edições, envie ao suporte.
                <a href="{{ route('app.publicacao.wizard.step1') }}" class="btn btn-sm btn-dark ms-2">
                    Solicitar publicação
                </a>
            @endif
        </div>
    @endif

    <div class="row g-4">

        <!-- STATUS DO SITE -->
        <div class="col-md-4">
            <div class="vg-card">

                <div class="vg-card-header d-flex justify-content-between align-items-center">
                    <span>Status do site</span>
                    @if ($site)
                        @switch($site->status)
                            @case('published')
                                <span class="status-ativo">Publicado ●</span>
                                @break
                            @case('draft')
                                <span style="color:#6c757d;font-size:14px;">Rascunho ●</span>
                                @break
                            @default
                                <span style="color:#6c757d;font-size:14px;">{{ $site->status }} ●</span>
                        @endswitch
                    @else
                        <span style="color:#6c757d;font-size:14px;">Sem site ●</span>
                    @endif
                </div>

                <div class="vg-card-body text-center">
                    @if ($site)
                        <a href="{{ route('app.sites.preview', $site) }}" target="_blank"
                           style="text-decoration:none;color:inherit;">
                            <img src="https://placehold.co/300x200?text={{ urlencode($site->name) }}"
                                 class="img-fluid rounded" alt="{{ $site->name }}">
                        </a>
                        <div class="mt-2" style="font-size:13px;color:#6c757d;">
                            {{ $site->name }}
                        </div>
                    @else
                        <img src="https://placehold.co/300x200?text=Nenhum+site" class="img-fluid rounded" alt="">
                        <div class="mt-2" style="font-size:13px;color:#6c757d;">
                            Escolha um template para começar.
                        </div>
                    @endif
                </div>

            </div>
        </div>

        <!-- ESTATÍSTICAS -->
        <div class="col-md-4">
            <div class="vg-card">

                <div class="vg-card-header">
                    <span>Estatísticas do Site</span>
                </div>

                <div class="vg-card-body">

                    <div class="stat-item">
                        <div class="stat-icon"></div>
                        <div>
                            <strong>—</strong>
                            <span>Visitantes</span>
                        </div>
                    </div>

                    <div class="stat-item">
                        <div class="stat-icon"></div>
                        <div>
                            <strong>—</strong>
                            <span>Cliques no WhatsApp</span>
                        </div>
                    </div>

                    <div class="stat-item">
                        <div class="stat-icon"></div>
                        <div>
                            <strong>—</strong>
                            <span>Tempo de Visualização</span>
                        </div>
                    </div>

                    <button class="btn btn-green mt-3" disabled>
                        Relatório
                    </button>

                </div>

            </div>
        </div>

        <!-- ASSINATURA -->
        <div class="col-md-4">
            <div class="vg-card">

                <div class="vg-card-header">
                    <span>Assinatura</span>
                </div>

                <div class="vg-card-body">

                    @if ($subscription)
                        <p class="plano">
                            {{ $subscription->plan_name ?? 'Profissional' }}
                        </p>
                        <small>Plano atual</small>

                        <p class="status mt-3">
                            {{ ucfirst($subscription->status ?? 'Ativo') }}
                        </p>
                        <small>
                            @if ($subscription->ended_at)
                                Renovação dia {{ $subscription->ended_at->format('d/m/Y') }}
                            @else
                                Assinatura ativa
                            @endif
                        </small>
                    @else
                        <p class="plano">—</p>
                        <small>Sem assinatura ativa</small>
                    @endif

                    <br>
                    <a href="{{ route('app.conta') }}" class="btn btn-green mt-3">
                        Ver Planos
                    </a>

                </div>

            </div>
        </div>

    </div>

</div>
@endsection
