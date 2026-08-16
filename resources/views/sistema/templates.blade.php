@extends('layouts.sistema')

@section('title', 'Templates — Evidenciar')

@push('head')
<style>
.tpl-card {
    background: var(--cor-areia);
    border-radius: var(--radius-padrao);
    overflow: hidden;
    box-shadow: var(--sombra-card);
    display: flex;
    flex-direction: column;
    height: 100%;
    transition: transform .15s ease, box-shadow .15s ease;
}
.tpl-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 16px 36px rgba(0,0,0,.12);
}
.tpl-card.is-current {
    outline: 2px solid var(--cor-verde);
    outline-offset: -2px;
}
.tpl-thumb {
    aspect-ratio: 16/10;
    background: #e6e6e6 center/cover no-repeat;
    position: relative;
}
.tpl-thumb--clean    { background-color: #f3f4f6; background-image: linear-gradient(135deg, #e0f2fe 0%, #ffffff 100%); }
.tpl-thumb--moderno  { background-image: linear-gradient(135deg, #7c3aed 0%, #f97316 100%); }
.tpl-thumb--elegante { background-image: linear-gradient(135deg, #0f0f10 0%, #3a2f1b 100%); }

.tpl-thumb .tpl-tag {
    position: absolute;
    top: 10px;
    left: 10px;
    background: #fff;
    color: #132d46;
    font-size: 11px;
    font-weight: 700;
    padding: 3px 8px;
    border-radius: 999px;
    text-transform: uppercase;
    letter-spacing: .4px;
}
.tpl-thumb .tpl-current-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    background: var(--cor-verde);
    color: #fff;
    font-size: 11px;
    font-weight: 700;
    padding: 3px 8px;
    border-radius: 999px;
    text-transform: uppercase;
    letter-spacing: .4px;
}
.tpl-body {
    padding: 18px 18px 20px;
    display: flex;
    flex-direction: column;
    gap: 10px;
    flex: 1;
}
.tpl-body h5 {
    margin: 0;
    color: #132d46;
    font-size: 17px;
    font-weight: 700;
}
.tpl-body p {
    margin: 0;
    color: #4a5258;
    font-size: 13px;
    line-height: 1.5;
}
.tpl-actions {
    margin-top: auto;
    display: flex;
    gap: 8px;
}
.tpl-actions .btn {
    flex: 1;
    font-size: 13px;
    font-weight: 600;
}
.tpl-empty {
    background: var(--cor-areia);
    border-radius: var(--radius-padrao);
    padding: 24px;
    text-align: center;
    color: #4a5258;
}
</style>
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h4 style="color:var(--cor-areia);margin:0;font-weight:700;">Templates</h4>
        <p style="color:rgba(237,236,225,.7);margin:4px 0 0;font-size:13px;">
            Escolha o visual do seu site. Você pode trocar de template a qualquer momento sem perder o conteúdo.
        </p>
    </div>
</div>

@if ($templates->isEmpty())
    <div class="tpl-empty">
        Nenhum template disponível no seu plano.
    </div>
@else
    <div class="row g-3">
        @foreach ($templates as $template)
            @php
                $isCurrent = $currentTemplateId === $template->id;
                $slug = $template->slug;
                $thumbClass = in_array($slug, ['clean','moderno','elegante'], true)
                    ? "tpl-thumb--{$slug}"
                    : '';
            @endphp

            <div class="col-md-6 col-lg-4">
                <div class="tpl-card {{ $isCurrent ? 'is-current' : '' }}">

                    <div class="tpl-thumb {{ $thumbClass }}">
                        <span class="tpl-tag">{{ $template->name }}</span>
                        @if ($isCurrent)
                            <span class="tpl-current-badge">Em uso</span>
                        @endif
                    </div>

                    <div class="tpl-body">
                        <h5>{{ $template->name }}</h5>
                        <p>{{ $template->description ?: 'Template padrão da biblioteca Evidenciar.' }}</p>

                        <div class="tpl-actions">
                            @if ($isCurrent)
                                <a href="{{ route('app.editor') }}"
                                   class="btn btn-green">
                                    Editar site
                                </a>
                            @else
                                <form method="POST"
                                      action="{{ route('app.templates.switch') }}"
                                      onsubmit="return confirm('Aplicar o template {{ $template->name }} ao seu site? Seu conteúdo é preservado.');"
                                      class="w-100 d-flex gap-2 m-0">
                                    @csrf
                                    <input type="hidden" name="template_id" value="{{ $template->id }}">
                                    <button type="submit" class="btn btn-green">
                                        Usar este
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection
