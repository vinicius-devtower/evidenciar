@if(!empty($plan))
    @php($isAnnual = ($cycle ?? 'monthly') === 'annual')
    <div class="ev-plan-ribbon">
        <div class="ev-plan-ribbon__label">Plano escolhido</div>
        <div class="ev-plan-ribbon__name">{{ $plan->name }}</div>
        @if ($isAnnual)
            <div class="ev-plan-ribbon__price">{{ $plan->annualPriceFormatted() }}<span>à vista/ano</span></div>
        @else
            <div class="ev-plan-ribbon__price">{{ $plan->priceFormatted() }}<span>/mês</span></div>
        @endif
    </div>

    @push('head')
    <style>
        .ev-plan-ribbon{
            display:flex; align-items:center; gap:14px;
            background:#eefaf4;
            border:1px solid #b7ecd7;
            border-radius:10px;
            padding: 10px 16px;
            margin: 0 0 22px;
            font-size:14px;
        }
        .ev-plan-ribbon__label{ color:#0b6b50; font-weight:600; }
        .ev-plan-ribbon__name{ color:#132d46; font-weight:700; flex:1; }
        .ev-plan-ribbon__price{ color:#0b6b50; font-weight:700; font-size:15px; }
        .ev-plan-ribbon__price span{ color:#267e87; font-weight:500; font-size:12.5px; margin-left:2px; }
    </style>
    @endpush
@endif
