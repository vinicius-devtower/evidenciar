<style>
    /* Compensa a altura do header fixo, tanto pro topo da página quanto
       pros links âncora do menu (senão o header cobre o topo da seção). */
    body {
        padding-top: 80px;
    }

    section[id] {
        scroll-margin-top: 80px;
    }
</style>

<header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

        <a href="{{ url('/') }}" class="logo d-flex align-items-center">
            <img src="{{ asset('landing/assets/img/logo/logo-black.png') }}" alt="Evidenciar" class="img-fluid">
        </a>

        <nav id="navmenu" class="navmenu">
            <ul>
                <li><a href="#meu-escritorio" class="active">Home</a></li>
                <li><a href="#como-funciona">Como Funciona</a></li>
                <li><a href="#templates">Templates</a></li>
                <li><a href="#pricing">Planos</a></li>
                <li><a href="#faq">FAQ</a></li>
                <li><a href="#" data-bs-toggle="modal" data-bs-target="#supportModal">Falar com Suporte</a></li>
            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>

    </div>
</header>
