<style>
    /* Compensa a altura do header fixo, tanto pro topo da página quanto
       pros links âncora do menu (senão o header cobre o topo da seção). */
    body {
        padding-top: 80px;
    }

    section[id] {
        scroll-margin-top: 80px;
    }

    /* --nav-color (tema padrão do template) é igual a --cor-areia (fundo
       do header) — os links do menu ficavam invisíveis, só "Home"
       aparecia por estar com a classe .active (cor verde do :hover).
       Sobrescrevendo pra cor de texto real do site. */
    .navmenu a {
        color: var(--cor-azul-escuro) !important;
    }

    .navmenu a:hover,
    .navmenu .active {
        color: var(--cor-verde) !important;
    }

    .mobile-nav-toggle {
        color: var(--cor-azul-escuro);
        font-size: 28px;
        line-height: 0;
        cursor: pointer;
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
