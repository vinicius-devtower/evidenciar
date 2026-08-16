<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Evidenciar — Sites profissionais</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container py-5">
        <h2 class="text-center mb-4">Como funciona?</h2>
        <div class="row justify-content-center">
            {{-- Plano Básico --}}
            <div class="col-md-4">
                <div class="card border-success">
                    <div class="card-header text-center fw-bold">
                        Plano Básico
                    </div>
                    <div class="card-body text-center">
                        <h3>R$ 49,90</h3>
                        <p class="text-muted">mensal</p>
                        <a href="{{ route('checkout.show', $template) }}" class="btn btn-success btn-lg">
                            Contratar plano básico
                        </a>
                    </div>
                </div>
            </div>
            {{-- Plano Premium (desativado) --}}
            <div class="col-md-4">
                <div class="card opacity-50">
                    <div class="card-header text-center fw-bold">
                        Plano Premium
                    </div>
                    <div class="card-body text-center">
                        <h3>Em breve</h3>
                        <button class="btn btn-secondary w-100" disabled>
                            Indisponível
                        </button>
                    </div>
                </div>
            </div>
            {{-- Plano Business (desativado) --}}
            <div class="col-md-4">
                <div class="card opacity-50">
                    <div class="card-header text-center fw-bold">
                        Plano Business
                    </div>
                    <div class="card-body text-center">
                        <h3>Em breve</h3>
                        <button class="btn btn-secondary w-100" disabled>
                            Indisponível
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
