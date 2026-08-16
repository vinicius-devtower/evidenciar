@extends('layouts.backoffice')
@section('title', $brief['name'] . ' · Templates padrão · Dev')

@section('content')
    <div class="d-flex align-items-center mb-3">
        <a href="{{ route('dev.templates-padrao.index') }}" class="btn btn-sm btn-outline-secondary me-3">
            <i class="bi bi-arrow-left"></i> Voltar
        </a>
        <div>
            <div class="text-muted small text-uppercase">{{ $slug }}</div>
            <h1 class="page-title mb-0">{{ $brief['name'] }}</h1>
        </div>
    </div>

    <p class="page-sub">{{ $brief['subtitle'] }}</p>

    <div class="bo-card mb-4">
        <div class="card-body">
            <p class="mb-2">{{ $brief['description'] }}</p>
            <details class="small text-muted mt-3">
                <summary class="fw-semibold text-body" style="cursor:pointer">Como ler este briefing</summary>
                <div class="mt-2">
                    <p class="mb-1">Cada página do site é uma sequência de blocos do registry. Cada bloco mostra:</p>
                    <ul class="mb-1">
                        <li><strong>Sketch</strong> — wireframe simplificado da estrutura do bloco.</li>
                        <li><strong>Campos editáveis</strong> — tag semântica (H1/H2/H3/P/CTA), label, max chars, obrigatoriedade.</li>
                        <li><strong>Imagens</strong> — quando o bloco tem áreas de imagem, lista label, dimensões e formato.</li>
                        <li><strong>Notas</strong> — regras de comportamento, responsividade e SEO.</li>
                    </ul>
                    <p class="mb-0">A equipe de criação produz templates por vertical respeitando esses contratos — assim o template fica editável no admin do cliente sem trabalho de dev.</p>
                </div>
            </details>
        </div>
    </div>

    {{-- Index lateral das páginas (sticky) --}}
    <div class="row">
        <aside class="col-lg-3 mb-4">
            <div class="bo-card tp-toc">
                <div class="card-header"><i class="bi bi-list-ul me-1"></i> Páginas ({{ count($pages) }})</div>
                <ul class="list-unstyled mb-0 small">
                    @foreach ($pages as $i => $p)
                        <li>
                            <a href="#page-{{ $i }}" class="d-flex justify-content-between align-items-center py-1 px-2 text-decoration-none">
                                <span><span class="text-muted me-1">{{ $i + 1 }}.</span> {{ $p['name'] }}</span>
                                <span class="badge bg-light text-muted border">{{ count($p['blocks']) }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </aside>

        <div class="col-lg-9">
            @foreach ($pages as $i => $p)
                <section id="page-{{ $i }}" class="tp-page mb-5">
                    <header class="tp-page__head">
                        <span class="tp-page__num">Página {{ $i + 1 }} de {{ count($pages) }}</span>
                        <h2 class="tp-page__title">{{ $p['name'] }}</h2>
                        @if (!empty($p['description']))
                            <p class="tp-page__desc">{{ $p['description'] }}</p>
                        @endif
                    </header>

                    @foreach ($p['blocks'] as $block)
                        @include('backoffice.dev.templates-padrao._block', ['block' => $block])
                    @endforeach
                </section>
            @endforeach
        </div>
    </div>

    @include('backoffice.dev.templates-padrao._styles')
@endsection
