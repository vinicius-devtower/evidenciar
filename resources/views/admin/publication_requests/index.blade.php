@extends('layouts.admin')
@section('content')
    <div class="container-fluid">
        <div class="alert alert-info">
            <strong>Aviso:</strong> esta tela foi movida para o novo painel do
            <a href="{{ route('suporte.publicacoes.index') }}">Suporte</a>.
        </div>
    </div>
@endsection
