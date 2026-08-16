@extends('layouts.sistema-guest')

@section('title', 'Recuperar senha — Evidenciar')

@section('content')
<div class="guest-card">

    {{-- Logo Evidenciar --}}
    <div class="guest-card__logo">
        <img src="{{ asset('landing/assets/img/logo/logo-black.svg') }}" alt="Evidenciar">
    </div>

    <h1 class="guest-card__title">Recuperar senha</h1>
    <p class="guest-card__sub">
        Informe seu e-mail para receber o link de recuperação.
    </p>

    {{-- Status (ex: "link de reset enviado") --}}
    @if (session('status'))
        <div class="alert alert-success py-2 mb-3">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" novalidate>
        @csrf

        {{-- E-mail --}}
        <div class="ev-field">
            <span class="ev-field__icon" aria-hidden="true">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="2" y="4" width="20" height="16" rx="2"></rect>
                    <path d="m22 6-10 7L2 6"></path>
                </svg>
            </span>
            <input type="email" name="email" id="email"
                   class="form-control @error('email') is-invalid @enderror"
                   placeholder="E-mail" value="{{ old('email') }}"
                   required autofocus autocomplete="username">
        </div>
        @error('email')
            <div class="ev-field__error">{{ $message }}</div>
        @enderror

        {{-- Botão enviar --}}
        <button type="submit" class="btn-ev btn-ev--block">Enviar link</button>

        {{-- Voltar --}}
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
