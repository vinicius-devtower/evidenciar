@extends('layouts.sistema-guest')

@section('title', 'Entrar — Evidenciar')

@section('content')
<div class="guest-card">

    {{-- Logo Evidenciar --}}
    <div class="guest-card__logo">
        <img src="{{ asset('landing/assets/img/logo/logo-black.svg') }}" alt="Evidenciar">
    </div>

    {{-- Status (ex: "link de reset enviado") --}}
    @if (session('status'))
        <div class="alert alert-success py-2 mb-3">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" novalidate>
        @csrf

        {{-- E-mail --}}
        <div class="ev-field">
            <span class="ev-field__icon" aria-hidden="true">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="8" r="4"></circle>
                    <path d="M4 21a8 8 0 0 1 16 0"></path>
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
                   placeholder="Senha" required autocomplete="current-password">
        </div>
        @error('password')
            <div class="ev-field__error">{{ $message }}</div>
        @enderror

        {{-- Lembrar + esqueceu --}}
        <div class="ev-options">
            <label>
                <input type="checkbox" id="lembrar" name="remember" {{ old('remember') ? 'checked' : '' }}>
                Lembra-me
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">Esqueceu a senha?</a>
            @endif
        </div>

        {{-- Botão Login --}}
        <button type="submit" class="btn-ev">Login</button>
    </form>

</div>
@endsection
