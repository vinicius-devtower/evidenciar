@extends('layouts.public')
@section('title', 'Pagamento não concluído')
@section('content')
<div class="container py-5 text-center">
    <h1 class="mb-3 text-danger">Pagamento não concluído</h1>
    <p class="lead">
        Não foi possível concluir o pagamento neste momento.
    </p>
    <p class="text-muted">
        Isso pode acontecer por dados inválidos, limite do cartão ou instabilidade temporária.
        Nenhuma cobrança foi realizada.
    </p>
    <div class="mt-4">
        <a href="{{ route('landing') }}" class="btn btn-secondary me-2">
            Voltar ao site
        </a>
        <a href="{{ url()->previous() }}" class="btn btn-success">
            Tentar novamente
        </a>
    </div>
</div>
@endsection
