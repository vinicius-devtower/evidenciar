@extends('layouts.sistema')
@section('title', 'Solicitar publicação — Revisar e enviar')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        @include('sistema.publicacao.wizard._steps', ['current' => 4])

        <div class="bo-card p-4" style="background:#fff; border:1px solid #e5e5e0; border-radius:6px;">
            <h4>Revise antes de enviar</h4>
            <p class="text-muted small">
                Ao enviar, nossa equipe recebe sua solicitação e você poderá acompanhar
                todo o processo por aqui, inclusive trocar mensagens com o suporte.
            </p>

            <div class="mb-3">
                <h6 class="small text-muted text-uppercase mb-2">Domínio</h6>
                @if (($draft['has_domain'] ?? '') === 'yes')
                    <div><span class="text-muted">Domínio:</span> <strong>{{ $draft['domain_name'] ?? '—' }}</strong></div>
                    <div><span class="text-muted">Registrador:</span> {{ $draft['registrar'] ?? '—' }}</div>
                @else
                    <div><span class="text-muted">Desejado:</span>
                        <strong>{{ ($draft['desired_domain'] ?? '—') . ($draft['extension'] ?? '') }}</strong></div>
                    <div><span class="text-muted">Ajuda com o registro:</span>
                        {{ ($draft['register_help'] ?? '') === 'yes' ? 'Sim' : 'Não' }}</div>
                @endif
                @if (!empty($draft['access_notes']))
                    <div class="mt-2 p-2" style="background:#fafaf7; border-radius:4px;">
                        {{ $draft['access_notes'] }}
                    </div>
                @endif
            </div>

            <div class="mb-3">
                <h6 class="small text-muted text-uppercase mb-2">Checklist</h6>
                @php $c = $draft['checklist'] ?? []; @endphp
                <ul class="small mb-0 list-unstyled">
                    @foreach ([
                        'content'=>'Conteúdo revisado',
                        'images'=>'Imagens definitivas',
                        'contacts'=>'Contatos preenchidos',
                        'branding'=>'Identidade visual pronta',
                    ] as $k => $l)
                        <li>
                            @if (!empty($c[$k]))
                                <span style="color:#21883a;">✓</span>
                            @else
                                <span style="color:#c53030;">○</span>
                            @endif
                            {{ $l }}
                        </li>
                    @endforeach
                </ul>
            </div>

            <form method="POST" action="{{ route('app.publicacao.wizard.submit') }}">
                @csrf
                <div class="d-flex justify-content-between">
                    <a href="{{ route('app.publicacao.wizard.step3') }}" class="btn btn-outline-dark">Voltar</a>
                    <button class="btn btn-dark">Enviar solicitação ao suporte</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
