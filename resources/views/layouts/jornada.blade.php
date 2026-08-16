<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Jornada — Evidenciar')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">

    @php
        // Modo "hero" (tela cheia azul) vs split (coluna esquerda + form).
        $hero = $hero ?? false;
    @endphp

    <style>
        :root{
            --ev-dark:   #132d46;
            --ev-green:  #01c38e;
            --ev-teal:   #267e87;
            --ev-ink:    #132d46;
            --ev-muted:  #9aa4b2;
            --ev-border: #dfe4ec;
            --ev-bg:     #f5f7fa;
        }
        *{box-sizing:border-box;}
        html,body{height:100%;}
        body{
            margin:0;
            font-family:'Inter',-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;
            color:var(--ev-ink);
            background:var(--ev-dark);
            -webkit-font-smoothing:antialiased;
        }

        /* ========================================================
           Bloco compartilhado: coluna azul com EVA + texto + logo
           ======================================================== */
        .ev-hero-side{
            position:relative;
            background-color:var(--ev-dark);
            background-image:url('{{ asset('storage/bg-azul-forte.png') }}');
            background-size:cover;
            background-position:center;
            background-repeat:no-repeat;
            color:#e9eef6;
            display:flex;
            flex-direction:column;
            align-items:center;
            justify-content:center;
        }
        .ev-hero-side__inner{
            max-width:520px;
            padding:40px;
            display:flex;
            align-items:center;
            gap:28px;
        }
        .ev-hero-side__eva{
            width:160px; height:auto; flex-shrink:0;
            filter: drop-shadow(0 18px 30px rgba(0,0,0,.25));
        }
        .ev-hero-side__eva--sm{ width:130px; }
        .ev-hero-side__text{
            font-size:17px; line-height:1.55; color:#e9eef6;
            font-weight:500;
        }
        .ev-hero-side__text strong{ font-weight:700; color:#fff; }
        .ev-hero-side__text p{ margin:0 0 14px; }
        .ev-hero-side__text p:last-child{ margin-bottom:0; }

        .ev-hero-side__logo{
            position:absolute;
            bottom:34px; left:0; right:0;
            text-align:center;
        }
        .ev-hero-side__logo img{ height:28px; opacity:.95; }

        /* ========================================================
           MODO HERO — tela cheia azul centralizada
           ======================================================== */
        @if($hero)
        .ev-hero{
            min-height:100vh;
            background-color:var(--ev-dark);
            background-image:url('{{ asset('storage/bg-azul-forte.png') }}');
            background-size:cover;
            background-position:center;
            background-repeat:no-repeat;
            display:flex; flex-direction:column;
            position:relative;
            padding: 48px 24px 100px;
        }
        .ev-hero__body{
            flex:1;
            display:flex; align-items:center; justify-content:center;
        }
        .ev-hero__inner{
            max-width:720px;
            display:flex; align-items:center; gap:40px;
            color:#e9eef6;
        }
        .ev-hero__eva{
            width:180px; height:auto;
            filter: drop-shadow(0 24px 40px rgba(0,0,0,.28));
        }
        .ev-hero__text{
            font-size:18px; line-height:1.55; color:#e9eef6;
            font-weight:500;
        }
        .ev-hero__text strong{ font-weight:700; color:#fff; }
        .ev-hero__text p{ margin:0 0 16px; }
        .ev-hero__text p:last-child{ margin-bottom:0; }

        .ev-hero__cta{
            display:flex; justify-content:flex-end;
            max-width:820px; margin:32px auto 0; width:100%;
        }

        .ev-hero__logo{
            position:absolute;
            bottom:32px; left:0; right:0;
            text-align:center;
        }
        .ev-hero__logo img{ height:30px; opacity:.95; }
        @endif

        /* ========================================================
           MODO SPLIT — coluna azul (esq) + formulário (dir)
           ======================================================== */
        @if(!$hero)
        .ev-split{
            display:grid;
            grid-template-columns: 1fr 2fr;
            min-height:100vh;
        }
        .ev-split__side{
            position:relative;
            background-color:var(--ev-dark);
            background-image:url('{{ asset('storage/bg-azul-forte.png') }}');
            background-size:cover;
            background-position:center;
            background-repeat:no-repeat;
            color:#e9eef6;
            display:flex; align-items:center; justify-content:center;
            padding:40px 28px 90px;
        }
        .ev-split__side-inner{
            display:flex; align-items:center; gap:22px;
            max-width:420px;
        }
        .ev-split__side-inner .eva{
            width:135px; height:auto; flex-shrink:0;
            filter: drop-shadow(0 16px 24px rgba(0,0,0,.28));
        }
        .ev-split__side-inner .text{
            font-size:15.5px; line-height:1.55; color:#e9eef6; font-weight:500;
        }
        .ev-split__side-inner .text strong{ font-weight:700; color:#fff; }
        .ev-split__side-inner .text p{ margin:0 0 12px; }
        .ev-split__side-inner .text p:last-child{ margin-bottom:0; }

        .ev-split__side-logo{
            position:absolute; bottom:28px; left:0; right:0; text-align:center;
        }
        .ev-split__side-logo img{ height:24px; opacity:.9; }

        .ev-split__main{
            background: var(--ev-bg);
            padding: 40px 56px 48px;
            display:flex; flex-direction:column;
            min-width:0;
        }

        @media (max-width: 900px){
            .ev-split{ grid-template-columns: 1fr; }
            .ev-split__side{ padding: 40px 20px 80px; min-height: 260px;}
            .ev-split__side-logo{ bottom:20px; }
            .ev-split__main{ padding: 32px 20px 40px; }
        }
        @endif

        /* ========================================================
           Stepper (Passo 01/02/03)
           ======================================================== */
        .ev-stepper{
            display:flex; gap:16px; margin: 0 0 34px;
            justify-content:center;
        }
        .ev-step{
            flex: 0 1 160px;
            text-align:center;
            padding: 11px 18px;
            border-radius: 10px;
            border: 1.5px solid var(--ev-green);
            color: var(--ev-green);
            background: #fff;
            font-size: 14.5px; font-weight:600;
            display:inline-flex; align-items:center; justify-content:center;
            gap: 7px;
            transition: background-color .12s, color .12s;
            text-decoration:none;
        }
        .ev-step.is-active{
            background: var(--ev-green);
            color:#fff;
            border-color: var(--ev-green);
        }
        .ev-step.is-done{
            background:#fff;
            color: var(--ev-green);
            border-color: var(--ev-green);
        }
        .ev-step.is-pending{
            background:#fff;
            color: var(--ev-muted);
            border-color: var(--ev-border);
        }
        .ev-step .check{
            width:16px; height:16px;
            display:inline-flex; align-items:center; justify-content:center;
        }

        /* ========================================================
           Form — inputs, labels, pílulas
           ======================================================== */
        .ev-label{
            display:block;
            font-size:14px; font-weight:500; color: var(--ev-ink);
            margin: 0 0 10px;
        }
        .ev-input{
            width:100%;
            height:58px;
            padding: 0 18px;
            border-radius: 10px;
            border:1px solid var(--ev-border);
            background:#fff;
            font-size:14.5px;
            color: var(--ev-ink);
            transition: border-color .12s, box-shadow .12s;
        }
        .ev-input::placeholder{ color:#b2bac7; font-style: italic; }
        .ev-input:focus{
            border-color: var(--ev-green);
            box-shadow: 0 0 0 3px rgba(1,195,142,.18);
            outline: none;
        }

        .ev-field{ margin-bottom: 22px; }
        .ev-field .ev-help{
            display:block; margin-top:6px;
            font-size:12.5px; color: var(--ev-muted);
        }
        .ev-field .ev-error{
            display:block; margin-top:6px;
            font-size:12.5px; color:#dc3545;
        }

        /* Pílulas de categoria (grid de opções) */
        .ev-pill-grid{
            display:grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 12px;
        }
        @media (max-width: 768px){
            .ev-pill-grid{ grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }
        .ev-pill{
            border-radius: 8px;
            border: 1.5px solid var(--ev-border);
            background:#fff;
            color: var(--ev-muted);
            font-size:13.5px; font-weight:600;
            padding: 11px 14px;
            text-align:center;
            cursor:pointer;
            transition: background-color .12s, color .12s, border-color .12s;
        }
        .ev-pill:hover{ border-color: var(--ev-teal); color: var(--ev-teal); }
        .ev-pill.is-selected{
            background: var(--ev-teal);
            color: #fff;
            border-color: var(--ev-teal);
        }

        /* ========================================================
           Botões
           ======================================================== */
        .btn-ev{
            background: var(--ev-green);
            border:0;
            color:#fff;
            font-weight:600;
            font-size:15px;
            border-radius:10px;
            padding: 12px 30px;
            min-height: 46px;
            display:inline-flex; align-items:center; justify-content:center;
            gap: 8px;
            transition: background-color .12s, transform .12s;
            text-decoration:none;
        }
        .btn-ev:hover{ background:#01a97b; color:#fff; }
        .btn-ev:active{ transform: translateY(1px); }
        .btn-ev--lg{ padding: 14px 40px; font-size:15.5px; min-height:50px; }

        .btn-ev-ghost{
            background: transparent;
            border:1.5px solid var(--ev-border);
            color: var(--ev-muted);
            font-weight:600; font-size:14px;
            border-radius:10px;
            padding: 10px 22px;
            text-decoration:none;
            display:inline-flex; align-items:center;
            transition: color .12s, border-color .12s;
        }
        .btn-ev-ghost:hover{ color: var(--ev-ink); border-color: var(--ev-ink); }

        /* ========================================================
           Alerts
           ======================================================== */
        .alert{
            border-radius:10px; border:1px solid transparent;
            font-size:13.5px;
        }
        .alert-warning{
            background:#fff6e5;
            border-color:#ffe0a3;
            color:#a06b00;
        }
        .alert-danger{
            background:#fdecec;
            border-color:#f5c6c6;
            color:#b02a37;
        }
        .alert-info{
            background: rgba(38, 126, 135, .1);
            border-color: rgba(38, 126, 135, .25);
            color: var(--ev-teal);
        }
        .alert-floating{
            position:fixed; top:20px; right:20px; z-index:999;
            max-width: 420px;
        }
    </style>
    @stack('head')
</head>
<body>

@if($hero)
    {{-- ============= HERO (tela cheia) ============= --}}
    <div class="ev-hero">
        <div class="ev-hero__body">
            @yield('content')
        </div>
        <div class="ev-hero__logo">
            <img src="{{ asset('landing/assets/img/logo/logo-white.svg') }}" alt="Evidenciar">
        </div>
    </div>
@else
    {{-- ============= SPLIT (EVA + form) ============= --}}
    <div class="ev-split">
        <aside class="ev-split__side">
            <div class="ev-split__side-inner">
                <img class="eva" src="{{ asset('storage/icone-EVA.svg') }}" alt="Eva, a assistente virtual">
                <div class="text">
                    @yield('sidebar')
                </div>
            </div>
            <div class="ev-split__side-logo">
                <img src="{{ asset('landing/assets/img/logo/logo-white.svg') }}" alt="Evidenciar">
            </div>
        </aside>

        <main class="ev-split__main">
            @if(session('warning'))
                <div class="alert alert-warning alert-floating">{{ session('warning') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger mb-3">
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
@endif

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
