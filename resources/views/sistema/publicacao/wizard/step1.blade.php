@extends('layouts.sistema')
@section('title', 'Solicitar publicação — Passo 1')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        @include('sistema.publicacao.wizard._steps', ['current' => 1])

        <div class="bo-card p-4" style="background:#fff; border:1px solid #e5e5e0; border-radius:6px;">
            <h4>Você já tem um domínio próprio?</h4>
            <p class="text-muted" style="font-size:14px;">
                Precisamos saber onde seu site deve ser publicado. Se ainda não tem um domínio
                (por exemplo <code>minhaempresa.com.br</code>), nós podemos ajudar a providenciar.
            </p>

            <form method="POST" action="{{ route('app.publicacao.wizard.step1.save') }}">
                @csrf
                <div class="mb-3">
                    <label class="card p-3 d-block" style="cursor:pointer; border:1px solid #e5e5e0;">
                        <input type="radio" name="has_domain" value="yes"
                               {{ ($draft['has_domain'] ?? '') === 'yes' ? 'checked' : '' }} required>
                        <strong class="ms-2">Sim, já tenho um domínio registrado.</strong>
                        <div class="text-muted small mt-1 ms-4">
                            Ex.: você comprou em Registro.br, GoDaddy, Hostgator, etc.
                        </div>
                    </label>
                </div>
                <div class="mb-4">
                    <label class="card p-3 d-block" style="cursor:pointer; border:1px solid #e5e5e0;">
                        <input type="radio" name="has_domain" value="no"
                               {{ ($draft['has_domain'] ?? '') === 'no' ? 'checked' : '' }} required>
                        <strong class="ms-2">Ainda não tenho e quero registrar um.</strong>
                        <div class="text-muted small mt-1 ms-4">
                            Nosso suporte orienta sobre extensão (.com.br, .com) e registrador.
                        </div>
                    </label>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('app.publicacao.index') }}" class="btn btn-outline-dark">Voltar</a>
                    <button class="btn btn-dark">Continuar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
