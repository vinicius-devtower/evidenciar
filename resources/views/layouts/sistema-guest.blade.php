<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Evidenciar')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --ev-dark:  #132d46;
            --ev-green: #01c38e;
            --ev-teal:  #267e87;
            --ev-ink:   #132d46;
            --ev-muted: #9aa4b2;
            --ev-border:#dfe4ec;
        }

        * { box-sizing: border-box; }
        html, body { height: 100%; }
        body {
            margin: 0;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            color: var(--ev-ink);
            background-color: var(--ev-dark);
            background-image: url('{{ asset('storage/bg-azul-forte.png') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            -webkit-font-smoothing: antialiased;
        }

        /* ------ Shell centralizador ------ */
        .guest-shell {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        /* ------ Card branco ------ */
        .guest-card {
            width: 100%;
            max-width: 440px;
            background: #fafbfc;
            border-radius: 14px;
            padding: 36px 40px 34px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, .18);
        }

        .guest-card__logo {
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 28px;
        }
        .guest-card__logo img { height: 58px; width: auto; }

        .guest-card__title {
            font-size: 20px; font-weight: 700; color: var(--ev-ink);
            margin: 0 0 4px; text-align: center;
        }
        .guest-card__sub {
            font-size: 13px; color: var(--ev-muted);
            margin: 0 0 24px; text-align: center;
        }

        /* ------ Inputs com ícone ------ */
        .ev-field {
            position: relative;
            margin-bottom: 16px;
        }
        .ev-field input.form-control {
            height: 52px;
            padding: 0 16px 0 48px;
            border-radius: 10px;
            border: 1px solid var(--ev-border);
            background: #fff;
            font-size: 14.5px;
            color: var(--ev-ink);
            transition: border-color .12s, box-shadow .12s;
        }
        .ev-field input.form-control::placeholder {
            color: #b2bac7;
        }
        .ev-field input.form-control:focus {
            border-color: var(--ev-green);
            box-shadow: 0 0 0 3px rgba(1, 195, 142, .18);
            outline: none;
        }
        .ev-field input.form-control.is-invalid {
            border-color: #dc3545;
        }
        .ev-field .ev-field__icon {
            position: absolute;
            left: 14px; top: 50%; transform: translateY(-50%);
            width: 22px; height: 22px;
            display: flex; align-items: center; justify-content: center;
            color: #a0a8b6; pointer-events: none;
        }

        .ev-field__error {
            color: #dc3545;
            font-size: 12px;
            margin: -10px 2px 12px;
        }

        /* ------ Opções (lembrar + esqueceu) ------ */
        .ev-options {
            display: flex; justify-content: space-between; align-items: center;
            font-size: 13px; margin: 6px 0 22px;
        }
        .ev-options label {
            color: var(--ev-muted);
            font-weight: 500;
            display: inline-flex; align-items: center; gap: 8px;
            cursor: pointer; margin: 0;
        }
        .ev-options input[type="checkbox"] {
            width: 18px; height: 18px;
            accent-color: var(--ev-green);
            cursor: pointer;
        }
        .ev-options a {
            color: var(--ev-muted);
            text-decoration: none;
            font-weight: 500;
        }
        .ev-options a:hover { color: var(--ev-ink); }

        /* ------ Botão primário verde ------ */
        .btn-ev {
            background: var(--ev-green);
            border: 0;
            color: #fff;
            font-weight: 600;
            font-size: 15px;
            border-radius: 10px;
            padding: 12px 34px;
            transition: background-color .12s, transform .12s;
        }
        .btn-ev:hover { background: #01a97b; color: #fff; }
        .btn-ev:active { transform: translateY(1px); }
        .btn-ev--block { width: 100%; }

        /* ------ Alerts ------ */
        .alert {
            border-radius: 10px; border: 1px solid transparent; font-size: 13px;
        }
        .alert-success {
            background: rgba(1, 195, 142, .12);
            border-color: rgba(1, 195, 142, .25);
            color: #0a8d66;
        }
        .alert-danger {
            background: #fdecec;
            border-color: #f5c6c6;
            color: #b02a37;
        }

        /* ------ Link back ------ */
        .ev-back {
            display: inline-flex; align-items: center; gap: 6px;
            font-size: 13px; color: var(--ev-muted);
            text-decoration: none; margin-top: 14px;
        }
        .ev-back:hover { color: var(--ev-ink); }

        @media (max-width: 480px) {
            .guest-card { padding: 28px 24px; }
        }
    </style>
    @stack('head')
</head>
<body>

<div class="guest-shell">
    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
