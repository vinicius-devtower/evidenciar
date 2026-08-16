@extends('layouts.public')
@section('title', 'Pagamento confirmado')
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm text-center">
                <div class="card-body p-4">
                    <div class="mb-3">
                        <i class="fas fa-check-circle text-success" style="font-size: 48px;"></i>
                    </div>
                    <h4 class="mb-3">
                        Pagamento confirmado!
                    </h4>
                    <p class="text-muted">
                        Seu pagamento foi aprovado com sucesso.
                        Já criamos sua conta e o seu site inicial.
                    </p>
                    <p class="text-muted">
                        Enviamos um e-mail para você definir sua senha
                        e acessar o painel.
                    </p>
                    <a href="{{ route('login') }}" class="btn btn-success btn-lg mt-3">
                        Acessar minha conta
                    </a>
                    <div class="mt-3 text-muted" style="font-size: 0.9rem;">
                        Não recebeu o e-mail? Verifique sua caixa de spam.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
