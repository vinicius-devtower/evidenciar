<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Backoffice — Evidenciar')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $user = auth()->user();
        $area = $area ?? 'suporte'; // suporte|financeiro|dev
        $areaLabels = [
            'suporte'    => 'Suporte',
            'financeiro' => 'Financeiro',
            'dev'        => 'Desenvolvimento',
        ];
        // Paleta pedida: #132d46 azul-escuro, #01c38e verde, #267e87 azul-médio.
        $areaColors = [
            'suporte'    => '#132d46',
            'financeiro' => '#01c38e',
            'dev'        => '#267e87',
        ];
        $areaColor = $areaColors[$area] ?? '#132d46';

        // ---- Chips de métricas por área ----------------------------------
        // Mantemos cada consulta curta e defensiva. Se falhar (ex.: migração
        // em andamento), o chip simplesmente não aparece.
        $chips = [];
        try {
            if ($area === 'suporte') {
                $abertas = \App\Models\PublicationRequest::whereIn('status', \App\Models\PublicationRequest::OPEN_STATUSES)->count();
                $dnsPend = \App\Models\PublicationRequest::where('status', 'dns_pending')->count();
                $chips[] = ['label' => 'PUB. ABERTAS', 'value' => $abertas, 'route' => route('suporte.publicacoes.index', ['status' => 'open'])];
                $chips[] = ['label' => 'DNS PENDENTE', 'value' => $dnsPend, 'route' => route('suporte.publicacoes.index', ['status' => 'dns_pending'])];
            } elseif ($area === 'financeiro') {
                $ativas = \App\Models\Subscription::where('status', 'active')->count();
                $inadimp = \App\Models\Subscription::whereIn('status', ['past_due', 'unpaid'])->count();
                $chips[] = ['label' => 'ASSIN. ATIVAS', 'value' => $ativas, 'route' => route('financeiro.assinaturas.index', ['status' => 'active'])];
                $chips[] = ['label' => 'INADIMPLENTES', 'value' => $inadimp, 'route' => route('financeiro.assinaturas.index', ['status' => 'past_due'])];
            } elseif ($area === 'dev') {
                $templates = \App\Models\Template::count();
                $versoes = \App\Models\TemplateVersion::where('is_active', true)->count();
                $chips[] = ['label' => 'TEMPLATES', 'value' => $templates, 'route' => route('dev.templates.index')];
                $chips[] = ['label' => 'VERSÕES ATIVAS', 'value' => $versoes, 'route' => route('dev.templates.index')];
            }
        } catch (\Throwable $e) { /* silencioso */ }

        // ---- Notificações: exceções das últimas 24h ----------------------
        $alertCount = 0;
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('error_logs')) {
                $alertCount = \App\Models\ErrorLog::where('occurred_at', '>=', now()->subDay())->count();
            }
        } catch (\Throwable $e) { /* silencioso */ }
    @endphp

    <style>
        /* ========================================================
           Backoffice — layout moderno (inspirado no devtower)
           ======================================================== */
        :root {
            --bo-area: {{ $areaColor }};
            --bo-area-soft: {{ $areaColor }}14;     /* ~8% alpha */
            --bo-area-mid:  {{ $areaColor }}33;     /* ~20% alpha */
            --bo-ink:      #132d46;
            --bo-green:    #01c38e;
            --bo-teal:     #267e87;
            --bo-bg:       #f5f7fa;
            --bo-surface:  #ffffff;
            --bo-border:   #e6eaf0;
            --bo-border-soft:#eef1f5;
            --bo-text:     #1b2734;
            --bo-muted:    #6b7785;
        }

        * { box-sizing: border-box; }
        html, body { height: 100%; }
        body {
            margin: 0;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: var(--bo-bg);
            color: var(--bo-text);
            font-size: 14px;
            -webkit-font-smoothing: antialiased;
        }

        /* --------- Shell ---------- */
        .bo-shell { display: flex; min-height: 100vh; }

        /* --------- Sidebar -------- */
        .bo-sidebar {
            width: 248px;
            background: var(--bo-surface);
            border-right: 1px solid var(--bo-border);
            display: flex; flex-direction: column;
            position: sticky; top: 0; height: 100vh;
            overflow-y: auto;
        }
        .bo-sidebar__brand {
            padding: 18px 20px 16px;
            display: flex; align-items: center; gap: 10px;
            border-bottom: 1px solid var(--bo-border-soft);
        }
        .bo-sidebar__logo {
            width: 34px; height: 34px; border-radius: 9px;
            background: var(--bo-area); color: #fff;
            display:flex; align-items:center; justify-content:center;
            font-weight: 800; font-size: 13px; letter-spacing: 0.5px;
        }
        .bo-sidebar__brand .brand-name {
            font-weight: 700; font-size: 15px; color: var(--bo-ink);
            letter-spacing: 0.2px; line-height: 1;
        }
        .bo-sidebar__brand .brand-sub {
            display:block; font-size: 11px; color: var(--bo-muted);
            margin-top: 3px; font-weight: 500;
        }
        .bo-sidebar__section {
            padding: 18px 14px 6px;
            font-size: 10.5px; font-weight: 600;
            color: var(--bo-muted);
            text-transform: uppercase; letter-spacing: 1.2px;
        }
        .bo-sidebar__nav { padding: 4px 10px; display: flex; flex-direction: column; gap: 2px; }
        .bo-nav-link {
            display: flex; align-items: center; gap: 11px;
            padding: 9px 12px;
            border-radius: 8px;
            color: #3b4756;
            text-decoration: none;
            font-size: 13.5px; font-weight: 500;
            transition: background-color .12s, color .12s;
            line-height: 1.2;
        }
        .bo-nav-link i { font-size: 16px; width: 18px; text-align: center; color: #8a94a2; }
        .bo-nav-link:hover { background: #f2f4f8; color: var(--bo-ink); }
        .bo-nav-link:hover i { color: var(--bo-area); }
        .bo-nav-link.active {
            background: var(--bo-area-soft);
            color: var(--bo-area);
            font-weight: 600;
        }
        .bo-nav-link.active i { color: var(--bo-area); }

        .bo-sidebar__footer {
            margin-top: auto;
            padding: 14px;
            border-top: 1px solid var(--bo-border-soft);
        }
        .bo-sidebar__status {
            display:flex; align-items: center; gap: 10px;
            padding: 10px 12px;
            background: #f7f9fc; border-radius: 10px;
            border: 1px solid var(--bo-border-soft);
        }
        .bo-sidebar__status .avatar {
            width: 34px; height: 34px; border-radius: 50%;
            background: var(--bo-area); color: #fff;
            display:flex; align-items:center; justify-content:center;
            font-size: 13px; font-weight: 700;
            flex-shrink: 0;
        }
        .bo-sidebar__status .who { font-size: 12.5px; font-weight: 600; color: var(--bo-ink); line-height: 1.2;}
        .bo-sidebar__status .role { font-size: 10.5px; color: var(--bo-muted); margin-top: 2px; text-transform: uppercase; letter-spacing: 0.6px; font-weight: 600;}
        .bo-sidebar__status .dot { width: 7px; height: 7px; border-radius: 50%; background: var(--bo-green); display: inline-block; margin-right: 5px; }

        /* --------- Main column ------------ */
        .bo-main { flex: 1; display: flex; flex-direction: column; min-width: 0; }

        /* --------- Topbar ---------- */
        .bo-topbar {
            background: var(--bo-surface);
            border-bottom: 1px solid var(--bo-border);
            padding: 10px 28px;
            display: flex; align-items: center; justify-content: space-between;
            gap: 16px;
            position: sticky; top: 0; z-index: 20;
            min-height: 64px;
        }
        .bo-topbar__left { display:flex; align-items:center; gap: 10px; flex-wrap: wrap; }
        .bo-topbar__right { display:flex; align-items:center; gap: 14px; flex-wrap: wrap; }

        .bo-area-switcher { display:flex; gap:4px; background:#f2f4f8; padding:4px; border-radius: 10px; }
        .bo-area-switcher a {
            padding: 6px 12px; border-radius: 7px;
            font-size: 12.5px; font-weight: 600;
            color: var(--bo-muted); text-decoration: none;
            display:flex; align-items:center; gap: 6px;
        }
        .bo-area-switcher a i { font-size: 13px; }
        .bo-area-switcher a.active { background: #fff; color: var(--bo-ink); box-shadow: 0 1px 2px rgba(0,0,0,.05); }

        .bo-chip {
            background: #f7f9fc;
            border: 1px solid var(--bo-border-soft);
            border-radius: 10px;
            padding: 6px 12px;
            display: flex; flex-direction: column; align-items:flex-start;
            text-decoration: none; color: inherit;
            min-width: 110px;
            line-height: 1;
            transition: border-color .12s;
        }
        .bo-chip:hover { border-color: var(--bo-area-mid); color: inherit; }
        .bo-chip .chip-label { font-size: 10px; color: var(--bo-muted); font-weight: 700; letter-spacing: 1px; }
        .bo-chip .chip-value { font-size: 15px; font-weight: 700; color: var(--bo-ink); margin-top: 4px; }

        .bo-chip--status {
            display: inline-flex; flex-direction: row; align-items: center;
            min-width: 0; padding: 6px 12px; gap: 7px;
            background: rgba(1, 195, 142, .1);
            border-color: rgba(1, 195, 142, .25);
            color: #0a8d66;
            font-size: 12.5px; font-weight: 600;
        }
        .bo-chip--status .dot { width:8px; height:8px; border-radius:50%; background: var(--bo-green); }

        .bo-icon-btn {
            position: relative;
            width: 38px; height: 38px;
            border-radius: 10px;
            background: #f2f4f8;
            border: 1px solid transparent;
            color: #4a5768;
            display: inline-flex; align-items: center; justify-content: center;
            text-decoration: none;
            font-size: 17px;
            transition: background-color .12s, color .12s;
        }
        .bo-icon-btn:hover { background: #e8ecf2; color: var(--bo-area); }
        .bo-icon-btn .dot-badge {
            position: absolute; top: 6px; right: 7px;
            min-width: 17px; height: 17px; padding: 0 4px;
            background: #dc3545; color: #fff;
            border-radius: 9px;
            font-size: 10px; font-weight: 700;
            display: inline-flex; align-items: center; justify-content: center;
            border: 2px solid var(--bo-surface);
        }

        .bo-user {
            display: inline-flex; align-items: center; gap: 10px;
            padding: 4px 6px 4px 10px;
            background: #f7f9fc;
            border-radius: 999px;
            border: 1px solid var(--bo-border-soft);
        }
        .bo-user__name { font-size: 12.5px; font-weight: 600; color: var(--bo-ink); line-height: 1;}
        .bo-user__role { font-size: 10.5px; color: var(--bo-muted); margin-top: 2px; text-transform: uppercase; letter-spacing: 0.6px; font-weight: 600;}
        .bo-user__avatar {
            width: 30px; height: 30px; border-radius: 50%;
            background: var(--bo-area); color: #fff;
            display: inline-flex; align-items: center; justify-content: center;
            font-size: 12px; font-weight: 700;
        }

        /* --------- Content area ---------- */
        .bo-content { padding: 26px 28px; max-width: 100%; flex: 1; }

        .page-title {
            font-size: 22px; font-weight: 700;
            color: var(--bo-ink);
            margin: 0 0 6px;
            display: flex; align-items: center; gap: 12px;
        }
        .page-title::before {
            content: '';
            display: inline-block;
            width: 4px; height: 22px;
            border-radius: 2px;
            background: var(--bo-area);
        }
        .page-sub {
            color: var(--bo-muted);
            font-size: 13.5px;
            margin: 0 0 22px;
            padding-left: 16px;
        }

        /* --------- Cards ---------- */
        .bo-card {
            background: var(--bo-surface);
            border: 1px solid var(--bo-border-soft);
            border-radius: 12px;
            overflow: hidden;
        }

        /* --------- Stat card (visão geral) ---------- */
        .bo-stat {
            background: var(--bo-surface);
            border: 1px solid var(--bo-border-soft);
            border-radius: 12px;
            padding: 16px 18px;
            display: flex; align-items: center; gap: 14px;
            position: relative;
            transition: border-color .12s, transform .12s;
            height: 100%;
        }
        .bo-stat:hover { border-color: var(--bo-area-mid); transform: translateY(-1px); }
        .bo-stat__icon {
            width: 42px; height: 42px; border-radius: 10px;
            background: var(--bo-area-soft);
            color: var(--bo-area);
            display: flex; align-items: center; justify-content: center;
            font-size: 19px; flex-shrink: 0;
        }
        .bo-stat__body { min-width: 0; line-height: 1.2; }
        .bo-stat__label {
            font-size: 10.5px; font-weight: 700;
            color: var(--bo-muted);
            text-transform: uppercase; letter-spacing: 1px;
            margin-bottom: 6px;
        }
        .bo-stat__value { font-size: 24px; font-weight: 700; color: var(--bo-ink); }
        .bo-stat__meta  { font-size: 11.5px; color: var(--bo-muted); margin-top: 2px; }
        .bo-stat--success .bo-stat__icon { background: rgba(1, 195, 142, .1); color: #0a8d66; }
        .bo-stat--warning .bo-stat__icon { background: rgba(245, 166, 35, .1); color: #c67b07; }
        .bo-stat--danger  .bo-stat__icon { background: rgba(220, 53, 69, .1);  color: #b02a37; }
        .bo-stat--info    .bo-stat__icon { background: rgba(38, 126, 135, .1); color: var(--bo-teal); }
        .bo-card > .card-header,
        .bo-card .card-header {
            background: #fafbfd;
            padding: 13px 18px;
            border-bottom: 1px solid var(--bo-border-soft);
            font-weight: 600; font-size: 13.5px;
            color: var(--bo-ink);
        }
        .bo-card > .card-header.text-danger,
        .bo-card .card-header.text-danger { color: #c0392b; }

        /* --------- Tables ---------- */
        .bo-card .table { margin-bottom: 0; }
        .bo-card .table thead th {
            background: #fafbfd;
            border-top: none;
            border-bottom: 1px solid var(--bo-border-soft);
            color: var(--bo-muted);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            font-size: 11px;
            padding: 11px 18px;
        }
        .bo-card .table tbody td {
            padding: 12px 18px;
            border-color: var(--bo-border-soft);
            vertical-align: middle;
        }
        .bo-card .table tbody tr:hover { background: #fafbfd; }

        /* --------- Forms & buttons ---------- */
        .form-control, .form-select {
            border-radius: 8px;
            border-color: var(--bo-border);
            font-size: 13.5px;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--bo-area);
            box-shadow: 0 0 0 3px var(--bo-area-soft);
        }
        .form-label.small { font-weight: 600; color: var(--bo-muted); text-transform: uppercase; letter-spacing: 0.5px; font-size: 10.5px;}
        .btn { border-radius: 8px; font-weight: 600; font-size: 13px; padding: 7px 14px; }
        .btn-dark { background: var(--bo-area); border-color: var(--bo-area); }
        .btn-dark:hover, .btn-dark:focus { background: var(--bo-ink); border-color: var(--bo-ink); }
        .btn-outline-dark { color: var(--bo-ink); border-color: var(--bo-border); background: #fff; }
        .btn-outline-dark:hover { background: var(--bo-area-soft); border-color: var(--bo-area); color: var(--bo-area); }
        .btn-outline-secondary { color: var(--bo-muted); border-color: var(--bo-border); background: #fff; }
        .btn-outline-secondary:hover { background: #f7f9fc; color: var(--bo-ink); border-color: var(--bo-border); }
        .btn-outline-light { color: #fff; border-color: rgba(255,255,255,.35); }

        /* --------- Alerts ---------- */
        .alert { border-radius: 10px; border: 1px solid transparent; font-size: 13.5px; }
        .alert-success { background: rgba(1, 195, 142, .1); border-color: rgba(1, 195, 142, .25); color: #0a8d66; }
        .alert-danger { background: #fdecec; border-color: #f5c6c6; color: #b02a37; }

        /* --------- Badges ---------- */
        .badge.bg-dark { background: var(--bo-ink) !important; }
        .badge.bg-success { background: var(--bo-green) !important; }
        .badge.bg-info { background: var(--bo-teal) !important; color: #fff !important;}
        .badge { font-weight: 600; padding: .45em .7em; border-radius: 6px; }

        /* --------- Pagination ---------- */
        .pagination .page-link { color: var(--bo-ink); border-color: var(--bo-border-soft); }
        .pagination .page-item.active .page-link { background: var(--bo-area); border-color: var(--bo-area); }

        /* --------- Utilities ---------- */
        a { color: var(--bo-area); }
        a:hover { color: var(--bo-ink); }

        /* --------- Responsive ---------- */
        @media (max-width: 992px) {
            .bo-sidebar { width: 220px; }
            .bo-topbar { padding: 10px 16px; }
            .bo-content { padding: 20px 16px; }
            .bo-chip { min-width: 0; }
        }
        @media (max-width: 768px) {
            .bo-sidebar { display: none; }
            .bo-area-switcher { display: none; }
        }
    </style>

    @stack('head')
</head>
<body>

<div class="bo-shell">

    {{-- =================== SIDEBAR =================== --}}
    <aside class="bo-sidebar">
        <div class="bo-sidebar__brand">
            <div class="bo-sidebar__logo">E</div>
            <div>
                <span class="brand-name">Evidenciar</span>
                <span class="brand-sub">{{ $areaLabels[$area] ?? 'Backoffice' }}</span>
            </div>
        </div>

        @hasSection('sidebar')
            @yield('sidebar')
        @else
            @include('layouts.partials.backoffice-sidebar', [
                'area' => $area,
                'page' => $page ?? '',
            ])
        @endif

        <div class="bo-sidebar__footer">
            <div class="bo-sidebar__status">
                <div class="avatar">{{ strtoupper(mb_substr($user?->name ?? '?', 0, 1)) }}</div>
                <div>
                    <div class="who">{{ $user?->name }}</div>
                    <div class="role"><span class="dot"></span>{{ ucfirst($user?->role ?? '') }}</div>
                </div>
            </div>
        </div>
    </aside>

    {{-- =================== MAIN =================== --}}
    <div class="bo-main">

        {{-- =============== TOPBAR =============== --}}
        <header class="bo-topbar">
            <div class="bo-topbar__left">
                @if ($user?->role === 'admin')
                    <nav class="bo-area-switcher" aria-label="Alternar área">
                        <a href="{{ route('suporte.inicio') }}" class="{{ $area === 'suporte' ? 'active' : '' }}">
                            <i class="bi bi-life-preserver"></i> Suporte
                        </a>
                        <a href="{{ route('financeiro.inicio') }}" class="{{ $area === 'financeiro' ? 'active' : '' }}">
                            <i class="bi bi-cash-coin"></i> Financeiro
                        </a>
                        <a href="{{ route('dev.inicio') }}" class="{{ $area === 'dev' ? 'active' : '' }}">
                            <i class="bi bi-code-slash"></i> Dev
                        </a>
                    </nav>
                @endif

                @foreach ($chips as $chip)
                    <a href="{{ $chip['route'] }}" class="bo-chip">
                        <span class="chip-label">{{ $chip['label'] }}</span>
                        <span class="chip-value">{{ $chip['value'] }}</span>
                    </a>
                @endforeach
            </div>

            <div class="bo-topbar__right">
                <span class="bo-chip bo-chip--status">
                    <span class="dot"></span> Ativo
                </span>

                <a href="{{ route('suporte.logs.excecoes.index') }}" class="bo-icon-btn" title="Exceções 24h">
                    <i class="bi bi-bell"></i>
                    @if ($alertCount > 0)
                        <span class="dot-badge">{{ $alertCount > 99 ? '99+' : $alertCount }}</span>
                    @endif
                </a>

                <div class="bo-user">
                    <div>
                        <div class="bo-user__name">{{ $user?->name }}</div>
                        <div class="bo-user__role">{{ ucfirst($user?->role ?? '') }}</div>
                    </div>
                    <div class="bo-user__avatar">{{ strtoupper(mb_substr($user?->name ?? '?', 0, 1)) }}</div>
                </div>

                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit" class="bo-icon-btn" title="Sair" style="border: none; cursor: pointer;">
                        <i class="bi bi-box-arrow-right"></i>
                    </button>
                </form>
            </div>
        </header>

        {{-- =============== CONTENT =============== --}}
        <main class="bo-content">

            @if (session('success'))
                <div class="alert alert-success py-2">
                    <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger py-2">
                    <i class="bi bi-exclamation-triangle me-1"></i> {{ session('error') }}
                </div>
            @endif

            @yield('content')

        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@stack('scripts')
</body>
</html>
