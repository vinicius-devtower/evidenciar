<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name'))</title>

    <link href="{{ asset('landing/assets/img/favicon.png') }}" rel="icon">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">

    {{-- Bootstrap + ícones --}}
    <link href="{{ asset('landing/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('landing/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">

    {{-- CSS principal --}}
    <link href="{{ asset('landing/assets/css/main.css') }}" rel="stylesheet">

    @stack('head')
</head>

<body class="public-page">
    <main>
        @yield('content')
    </main>

    <script src="{{ asset('landing/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    @stack('scripts')
</body>
</html>
