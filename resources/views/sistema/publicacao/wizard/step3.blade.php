@extends('layouts.sistema')
@section('title', 'Solicitar publicação — Checklist')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        @include('sistema.publicacao.wizard._steps', ['current' => 3])

        <div class="bo-card p-4" style="background:#fff; border:1px solid #e5e5e0; border-radius:6px;">
            <h4>Checklist antes de publicar</h4>
            <p class="text-muted small">
                Confirme os itens abaixo para que o suporte publique seu site sem
                idas e voltas. Você ainda poderá editar depois, mas é bom começar certo.
            </p>

            <form method="POST" action="{{ route('app.publicacao.wizard.step3.save') }}">
                @csrf
                @php $c = $draft['checklist'] ?? []; @endphp
                @foreach ([
                    'check_content'  => ['Conteúdo revisado', 'Revisei todos os textos do site (títulos, descrições, serviços, etc.).'],
                    'check_images'   => ['Imagens definitivas', 'As imagens que aparecem no site são as que quero publicar.'],
                    'check_contacts' => ['Contatos preenchidos', 'Os canais de contato (WhatsApp, e-mail, redes) estão ativos e corretos.'],
                    'check_branding' => ['Identidade visual pronta', 'Logos e cores configurados em "Identidade visual".'],
                ] as $field => [$title, $desc])
                    <label class="card p-3 d-flex gap-3 mb-2" style="cursor:pointer; border:1px solid #e5e5e0;">
                        <input type="hidden" name="{{ $field }}" value="0">
                        <input type="checkbox" name="{{ $field }}" value="1"
                            {{ ($c[str_replace('check_','',$field)] ?? false) ? 'checked' : '' }}>
                        <div>
                            <strong>{{ $title }}</strong>
                            <div class="text-muted small">{{ $desc }}</div>
                        </div>
                    </label>
                @endforeach

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('app.publicacao.wizard.step2') }}" class="btn btn-outline-dark">Voltar</a>
                    <button class="btn btn-dark">Continuar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
