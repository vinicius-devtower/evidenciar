@extends('layouts.sistema')
@section('title', 'Publicação — Evidenciar')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h2 style="font-size:22px; font-weight:700; margin-bottom:4px;">Publicação do site</h2>
                <p class="text-muted mb-0" style="font-size:14px;">
                    Acompanhe o status e converse com o time de suporte.
                </p>
            </div>
            @if (!$current || !$current->isOpen())
                <a href="{{ route('app.publicacao.wizard.step1') }}" class="btn btn-dark">
                    Solicitar publicação
                </a>
            @endif
        </div>

        @if (!$current)
            <div class="bo-card p-4" style="background:#fff; border:1px solid #e5e5e0; border-radius:6px;">
                <h5>Pronto para publicar?</h5>
                <p class="text-muted">
                    Quando quiser que seu site vá ao ar, inicie a solicitação. Nosso time
                    cuida da configuração de domínio e DNS para você.
                </p>
                <a href="{{ route('app.publicacao.wizard.step1') }}" class="btn btn-dark">
                    Iniciar solicitação
                </a>
            </div>
        @else
            @include('sistema.publicacao.partials.current', ['pub' => $current])
        @endif
    </div>
</div>
@endsection
