@php($hero = true)
@extends('layouts.jornada')
@section('title', 'Bem-vindo(a)')

@section('content')
    <div class="ev-hero__inner d-flex flex-column flex-sm-row align-items-center justify-content-center text-center text-sm-start gap-4 mx-auto">
        <img class="ev-hero__eva flex-shrink-0" src="{{ asset('storage/icone-EVA.svg') }}" alt="Eva, a assistente virtual">
        <div class="ev-hero__text">
            <p><strong>Olá! Sou a Eva,</strong><br>a assistente virtual da Evidenciar!</p>
            @if($plan)
                <p>Você escolheu o plano <strong>{{ $plan->name }}</strong><br>({{ $plan->priceFormatted() }}/mês).</p>
            @endif
            <p>Vamos configurar o seu site em<br>apenas 3 passos simples!</p>
        </div>
    </div>

    <div class="ev-hero__cta d-flex justify-content-center mx-auto">
        <a href="{{ route('jornada.step1') }}" class="btn-ev btn-ev--lg">Iniciar</a>
    </div>
@endsection
