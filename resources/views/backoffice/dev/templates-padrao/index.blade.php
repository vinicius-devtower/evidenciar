@extends('layouts.backoffice')
@section('title', 'Templates padrão · Dev')

@section('content')
    <h1 class="page-title">Templates padrão</h1>
    <p class="page-sub">
        Spec viva dos 3 tipos de site oferecidos pelo Evidenciar.
        A equipe de criação usa esses wireframes como referência ao produzir templates por vertical.
    </p>

    <div class="row g-3 mb-4">
        @foreach ([
            ['label' => 'Tipos de site', 'value' => count($cards), 'icon' => 'bi-file-earmark-text'],
            ['label' => 'Blocos no registry', 'value' => $blocks_total, 'icon' => 'bi-collection'],
        ] as $card)
            <div class="col-6 col-md-3">
                <div class="bo-stat">
                    <div class="bo-stat__icon"><i class="bi {{ $card['icon'] }}"></i></div>
                    <div class="bo-stat__body">
                        <div class="bo-stat__label">{{ $card['label'] }}</div>
                        <div class="bo-stat__value">{{ $card['value'] }}</div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row g-3">
        @foreach ($cards as $card)
            <div class="col-12 col-lg-4">
                <a href="{{ route('dev.templates-padrao.show', $card['slug']) }}" class="bo-card tp-card text-decoration-none d-block h-100">
                    <div class="card-header">
                        <span class="text-muted text-uppercase small">{{ $card['slug'] }}</span>
                    </div>
                    <div class="card-body">
                        <h2 class="h5 mb-1">{{ $card['name'] }}</h2>
                        <p class="text-muted small mb-3">{{ $card['subtitle'] }}</p>
                        <p class="small text-body mb-3">{{ $card['description'] }}</p>
                        <div class="d-flex gap-2">
                            <span class="badge bg-light text-dark border">
                                <i class="bi bi-files me-1"></i> {{ $card['pages_count'] }} {{ $card['pages_count'] === 1 ? 'página' : 'páginas' }}
                            </span>
                            <span class="badge bg-light text-dark border">
                                <i class="bi bi-collection me-1"></i> {{ $card['blocks_count'] }} blocos únicos
                            </span>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <span class="text-primary fw-semibold small">Abrir briefing  →</span>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

    <style>
        .tp-card { transition: transform .12s ease, box-shadow .12s ease; cursor: pointer; }
        .tp-card:hover { transform: translateY(-2px); box-shadow: 0 8px 18px rgba(0,0,0,.06); }
        .tp-card .card-footer { background: transparent; border-top: 1px solid #eef0ee; }
    </style>
@endsection
