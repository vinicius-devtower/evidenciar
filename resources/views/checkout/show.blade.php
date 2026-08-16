<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Checkout — {{ $template->name }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="mb-3 text-center">
                        Criar site com o template
                        <strong>{{ $template->name }}</strong>
                    </h3>
                    <p class="text-center text-muted mb-4">
                        Valor: <strong>R$ {{ number_format($price, 2, ',', '.') }}</strong> / mês
                    </p>
                    {{-- Exibição de erros --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('checkout.create', $template) }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Nome</label>
                            <input type="text"
                                   name="name"
                                   class="form-control"
                                   value="{{ old('name') }}"
                                   required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">E-mail</label>
                            <input type="email"
                                   name="email"
                                   class="form-control"
                                   value="{{ old('email') }}"
                                   required>
                        </div>
                        {{-- <div class="mb-4">
                            <label class="form-label">Senha de acesso</label>
                            <input type="password"
                                   name="password"
                                   class="form-control"
                                   required>
                        </div> --}}
                        <button type="submit" class="btn btn-success w-100 btn-lg">
                            Prosseguir para pagamento
                        </button>
                    </form>
                </div>
            </div>
            <p class="text-center text-muted mt-3" style="font-size: 0.9rem;">
                Você será redirecionado para o checkout seguro do Mercado Pago.
            </p>
        </div>
    </div>
</div>
</body>
</html>
