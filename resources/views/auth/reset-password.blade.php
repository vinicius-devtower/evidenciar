@extends('layouts.sistema-guest')

@section('title', 'Definir senha — Evidenciar')

@section('content')
<div class="guest-card">

    {{-- Logo Evidenciar --}}
    <div class="guest-card__logo">
        <img src="{{ asset('landing/assets/img/logo/logo-black.svg') }}" alt="Evidenciar">
    </div>

    <h1 class="guest-card__title">
        {{ $request->route('token') ? 'Definir sua senha' : 'Redefinir senha' }}
    </h1>
    <p class="guest-card__sub">
        Crie uma senha segura para acessar sua conta.
    </p>

    <form method="POST" action="{{ route('password.store') }}" novalidate>
        @csrf

        {{-- Token --}}
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

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
                   placeholder="E-mail" value="{{ old('email', $request->email) }}"
                   required autofocus autocomplete="username">
        </div>
        @error('email')
            <div class="ev-field__error">{{ $message }}</div>
        @enderror

        {{-- Nova senha --}}
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
                   placeholder="Nova senha" required autocomplete="new-password">
        </div>
        @error('password')
            <div class="ev-field__error">{{ $message }}</div>
        @enderror

        {{-- Confirmar senha --}}
        <div class="ev-field">
            <span class="ev-field__icon" aria-hidden="true">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                </svg>
            </span>
            <input type="password" name="password_confirmation" id="password_confirmation"
                   class="form-control"
                   placeholder="Confirmar senha" required autocomplete="new-password">
        </div>

        {{-- Botão salvar --}}
        <button type="submit" class="btn-ev btn-ev--block">Salvar senha</button>

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
