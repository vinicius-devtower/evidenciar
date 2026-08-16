@extends('layouts.sistema-guest')

@section('title', 'Verificar e-mail — Evidenciar')

@section('content')
<div class="guest-card">

    {{-- Logo Evidenciar --}}
    <div class="guest-card__logo">
        <img src="{{ asset('landing/assets/img/logo/logo-black.svg') }}" alt="Evidenciar">
    </div>

    <h1 class="guest-card__title">Verifique seu e-mail</h1>
    <p class="guest-card__sub">
        Enviamos um link de verificação para o e-mail cadastrado.
        Clique no link para ativar sua conta.
    </p>

    @if (session('status') == 'verification-link-sent')
        <div class="alert alert-success py-2 mb-3">
            Enviamos um novo link de verificação para o seu e-mail.
        </div>
    @endif

    {{-- Reenviar link --}}
    <form method="POST" action="{{ route('verification.send') }}" novalidate>
        @csrf
        <button type="submit" class="btn-ev btn-ev--block">
            Reenviar e-mail de verificação
        </button>
    </form>

    {{-- Sair --}}
    <form method="POST" action="{{ route('logout') }}" style="text-align:center;">
        @csrf
        <button type="submit"
                style="background:none;border:0;padding:0;color:var(--ev-muted);
                       font-size:13px;margin-top:14px;cursor:pointer;text-decoration:underline;">
            Sair da conta
        </button>
    </form>

</div>
@endsection
