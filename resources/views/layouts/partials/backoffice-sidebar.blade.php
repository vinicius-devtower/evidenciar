@php
    $page = $page ?? '';
    $area = $area ?? 'suporte';
@endphp

<nav class="bo-sidebar__nav">
@if ($area === 'suporte')
    <div class="bo-sidebar__section">Suporte</div>

    <a href="{{ route('suporte.inicio') }}"
       class="bo-nav-link {{ $page === 'inicio' ? 'active' : '' }}">
        <i class="bi bi-grid-1x2"></i> Visão geral
    </a>
    <a href="{{ route('suporte.publicacoes.index') }}"
       class="bo-nav-link {{ $page === 'publicacoes' ? 'active' : '' }}">
        <i class="bi bi-inbox"></i> Fila de publicações
    </a>
    <a href="{{ route('suporte.publicacoes.index', ['status'=>'dns_pending']) }}"
       class="bo-nav-link {{ $page === 'dns' ? 'active' : '' }}">
        <i class="bi bi-globe2"></i> DNS pendente
    </a>
    <a href="{{ route('suporte.assinantes.index') }}"
       class="bo-nav-link {{ $page === 'assinantes' ? 'active' : '' }}">
        <i class="bi bi-people"></i> Assinantes
    </a>

    <div class="bo-sidebar__section">Logs</div>
    <a href="{{ route('suporte.logs.index') }}"
       class="bo-nav-link {{ $page === 'logs' ? 'active' : '' }}">
        <i class="bi bi-speedometer2"></i> Visão geral
    </a>
    <a href="{{ route('suporte.logs.excecoes.index') }}"
       class="bo-nav-link {{ $page === 'logs-excecoes' ? 'active' : '' }}">
        <i class="bi bi-exclamation-octagon"></i> Exceções
    </a>
    <a href="{{ route('suporte.logs.webhooks.index') }}"
       class="bo-nav-link {{ $page === 'logs-webhooks' ? 'active' : '' }}">
        <i class="bi bi-broadcast-pin"></i> Webhooks
    </a>
    <a href="{{ route('suporte.logs.atividade.index') }}"
       class="bo-nav-link {{ $page === 'logs-atividade' ? 'active' : '' }}">
        <i class="bi bi-clock-history"></i> Atividade
    </a>
    <a href="{{ route('suporte.logs.emails.index') }}"
       class="bo-nav-link {{ $page === 'logs-emails' ? 'active' : '' }}">
        <i class="bi bi-envelope"></i> E-mails
    </a>

@elseif ($area === 'financeiro')
    <div class="bo-sidebar__section">Financeiro</div>
    <a href="{{ route('financeiro.inicio') }}"
       class="bo-nav-link {{ $page === 'inicio' ? 'active' : '' }}">
        <i class="bi bi-grid-1x2"></i> Visão geral
    </a>
    <a href="{{ route('financeiro.assinaturas.index') }}"
       class="bo-nav-link {{ $page === 'assinaturas' ? 'active' : '' }}">
        <i class="bi bi-credit-card"></i> Assinaturas
    </a>
    <a href="{{ route('financeiro.pagamentos.index') }}"
       class="bo-nav-link {{ $page === 'pagamentos' ? 'active' : '' }}">
        <i class="bi bi-cash-coin"></i> Pagamentos
    </a>

@elseif ($area === 'dev')
    <div class="bo-sidebar__section">Desenvolvimento</div>
    <a href="{{ route('dev.inicio') }}"
       class="bo-nav-link {{ $page === 'inicio' ? 'active' : '' }}">
        <i class="bi bi-grid-1x2"></i> Visão geral
    </a>
    <a href="{{ route('dev.templates.index') }}"
       class="bo-nav-link {{ $page === 'templates' ? 'active' : '' }}">
        <i class="bi bi-layers"></i> Templates &amp; versões
    </a>
    <a href="{{ route('dev.templates-padrao.index') }}"
       class="bo-nav-link {{ $page === 'templates-padrao' ? 'active' : '' }}">
        <i class="bi bi-rulers"></i> Templates padrão
    </a>
    <a href="{{ route('dev.planos.index') }}"
       class="bo-nav-link {{ $page === 'planos' ? 'active' : '' }}">
        <i class="bi bi-tags"></i> Planos
    </a>

    <div class="bo-sidebar__section">Integrações</div>
    <a href="{{ route('dev.integracoes.mercadopago') }}"
       class="bo-nav-link {{ $page === 'integracoes-mercadopago' ? 'active' : '' }}">
        <i class="bi bi-credit-card-2-back"></i> Mercado Pago
    </a>
@endif
</nav>
