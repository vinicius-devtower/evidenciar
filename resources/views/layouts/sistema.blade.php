<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Painel — Evidenciar')</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Sistema -->
    <link rel="stylesheet" href="{{ asset('sistema/css/style.css') }}">

    <!-- Fonte -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    @stack('head')
</head>
<body>

<div class="app-wrapper">

    <!-- HEADER -->
    <div class="app-header">
        <div class="container-fluid d-flex justify-content-between align-items-center">

            <div class="app-logo">
                <a href="{{ route('app.inicio') }}">
                    <img src="https://placehold.co/140x32?text=Evidenciar" alt="Evidenciar">
                </a>
            </div>

            <div class="app-actions d-flex align-items-center gap-2">
                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit"
                            class="btn btn-sm"
                            style="background:transparent;color:#edece1;border:1px solid rgba(237,236,225,.4);border-radius:6px;">
                        Sair
                    </button>
                </form>
            </div>

        </div>
    </div>

    <!-- MENU ABAS -->
    <div class="app-tabs">
        <div class="container-fluid">
            <div class="tabs-wrapper">

                @php $page = $page ?? ''; @endphp

                <a href="{{ route('app.inicio') }}"
                   class="tab-item {{ $page === 'visao-geral' ? 'active' : '' }}">
                    Visão Geral
                </a>

                <a href="{{ route('app.templates') }}"
                   class="tab-item {{ $page === 'templates' ? 'active' : '' }}">
                    Templates
                </a>

                <a href="{{ route('app.editor') }}"
                   class="tab-item {{ $page === 'editor' ? 'active' : '' }}">
                    Editor do Site
                </a>

                <a href="{{ route('app.publicacao.index') }}"
                   class="tab-item {{ $page === 'publicacao' ? 'active' : '' }}">
                    Publicação
                </a>

                <a href="{{ route('app.tutoriais') }}"
                   class="tab-item {{ $page === 'tutoriais' ? 'active' : '' }}">
                    Tutoriais
                </a>

                <a href="{{ route('app.conta') }}"
                   class="tab-item {{ $page === 'conta' ? 'active' : '' }}">
                    Conta
                </a>

            </div>
        </div>
    </div>

    <!-- CONTEÚDO -->
    <div class="app-content">
        <div class="container-fluid">

            @if (session('success'))
                <div class="alert alert-success py-2" style="font-size:14px;">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger py-2" style="font-size:14px;">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')

        </div>
    </div>

</div>

<!-- MODAL VIDEO -->
<div class="modal fade" id="modalVideo" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content modal-video">
            <div class="modal-body p-0">
                <video id="videoPlayer" controls>
                    <source src="" type="video/mp4">
                    Seu navegador não suporta vídeo.
                </video>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('sistema/js/app.js') }}"></script>

@stack('scripts')

</body>
</html>
