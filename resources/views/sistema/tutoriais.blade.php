@extends('layouts.sistema')

@section('title', 'Tutoriais — Evidenciar')

@section('content')
<div class="tutoriais">

    @php
        $tutoriais = [
            [
                'titulo' => 'SEJA BEM-VINDO',
                'descricao' => 'Apresentação geral da plataforma Evidenciar.',
                'video' => asset('sistema/videos/tutorial1.mp4'),
            ],
            [
                'titulo' => 'VISÃO GERAL',
                'descricao' => 'Como ler os cards da Visão Geral e acompanhar estatísticas.',
                'video' => asset('sistema/videos/tutorial1.mp4'),
            ],
            [
                'titulo' => 'EDITOR DO SITE',
                'descricao' => 'Como editar seções do seu site pela barra lateral e salvar alterações.',
                'video' => asset('sistema/videos/tutorial1.mp4'),
            ],
        ];
    @endphp

    @foreach ($tutoriais as $tut)
        <div class="tutorial-item">
            <div class="tutorial-thumb">
                <img src="https://placehold.co/300x180?text={{ urlencode($tut['titulo']) }}" alt="">
            </div>
            <div class="tutorial-content">
                <h6>{{ $tut['titulo'] }}</h6>
                <p>{{ $tut['descricao'] }}</p>
                <button class="btn btn-blue btn-play-video"
                        data-bs-toggle="modal" data-bs-target="#modalVideo"
                        data-video="{{ $tut['video'] }}">
                    Assistir
                </button>
            </div>
        </div>
    @endforeach

</div>
@endsection
