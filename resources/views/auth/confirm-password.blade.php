@extends('layouts.sistema-guest')

@section('title', 'Confirmar senha — Evidenciar')

@section('content')
<div class="guest-card">

    {{-- Logo Evidenciar --}}
    <div class="guest-card__logo">
        <img src="{{ asset('landing/assets/img/logo/logo-black.svg') }}" alt="Evidenciar">
    </div>

    <h1 class="guest-card__title">Confirmar senha</h1>
    <p class="guest-card__sub">
        Esta é uma área restrita. Confirme sua senha para continuar.
    </p>

    <form method="POST" action="{{ route('password.confirm') }}" novalidate>
        @csrf

        {{-- Senha --}}
        <div class="ev-field">
            <span class="ev-field__icon" aria-hidden="true">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                </svg>
            </span>
            <input type="password" name="password" id="password"
                   class="form-control @error('password') is-invalid @enderror"
                   placeholder="Senha" required autocomplete="current-password" autofocus>
        </div>
        @error('password')
            <div class="ev-field__error">{{ $message }}</div>
        @enderror

        <button type="submit" class="btn-ev btn-ev--block">Confirmar</button>

        <div style="text-align:center;">
            <a href="{{ route('login') }}" class="ev-back">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 12H5"></path>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                Voltar para login
            </a>
        </div>
    </form>

</div>
@endsection
