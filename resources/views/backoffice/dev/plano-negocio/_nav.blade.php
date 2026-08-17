@php($current = Route::currentRouteName())
<ul class="nav nav-pills mb-4">
    <li class="nav-item">
        <a class="nav-link {{ $current === 'dev.plano-negocio.index' ? 'active' : '' }}"
           href="{{ route('dev.plano-negocio.index') }}">Visão geral</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $current === 'dev.plano-negocio.indicadores' ? 'active' : '' }}"
           href="{{ route('dev.plano-negocio.indicadores') }}">Indicadores</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $current === 'dev.plano-negocio.projecao' ? 'active' : '' }}"
           href="{{ route('dev.plano-negocio.projecao') }}">Projeção financeira</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $current === 'dev.plano-negocio.estrategias' ? 'active' : '' }}"
           href="{{ route('dev.plano-negocio.estrategias') }}">Estratégias de venda</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $current === 'dev.plano-negocio.contrato' ? 'active' : '' }}"
           href="{{ route('dev.plano-negocio.contrato') }}">Minuta de contrato</a>
    </li>
</ul>
