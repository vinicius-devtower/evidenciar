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

    /* A página já tem overflow horizontal pré-existente no mobile (hero
       mais largo que a tela). Isso faz elementos fixed herdarem a largura
       "vazada" do documento em vez da largura real da viewport, jogando o
       ícone do menu pra fora da tela. Travando a largura do header
       explicitamente pra não depender disso. */
    #header {
        width: 100vw;
        max-width: 100vw;
        overflow-x: hidden;
    }

    /* O CSS padrão do template posiciona o <ul> do menu mobile com
       position:absolute + inset relativo ao ancestral posicionado mais
       próximo — que aqui é o próprio #header (fixed, baixo). Isso colapsa
       o menu com altura 0 (bottom:20px fica acima do top:60px). Fixando
       relativo à viewport, sem depender da altura do header. */
    @media (max-width: 1199px) {
        .navmenu ul {
            position: fixed;
            top: 76px;
            left: 20px;
            right: 20px;
            bottom: 20px;
            padding: 20px;
            overflow-y: auto;
            z-index: 998;
        }

        .navmenu ul li {
            margin-bottom: 8px;
        }

        .navmenu ul a {
            display: block;
            padding: 10px 5px;
            font-size: 18px;
        }
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
