@extends('layouts.backoffice')
@section('title', 'Integração — Mercado Pago')

@section('content')
    <h1 class="page-title mb-1">Integrações — Mercado Pago</h1>
    <p class="text-muted mb-3">
        Credenciais usadas pelo checkout (PIX/Boleto/Cartão) e pela validação
        de webhooks. Se um campo aqui ficar vazio, o sistema usa o valor do
        <code>.env</code> deste ambiente como reserva — preencher aqui tem
        prioridade e não exige novo deploy pra trocar.
    </p>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="bo-card p-3 mb-3">
        <h6 class="mb-2"><i class="bi bi-broadcast-pin"></i> URL de notificação (webhook) deste ambiente</h6>
        <p class="text-muted small mb-2">
            É essa a URL que precisa estar cadastrada no painel do Mercado
            Pago (Sua integração → Webhooks) pra esse ambiente receber
            confirmação de pagamento.
        </p>
        <code class="d-block bg-light p-2 rounded">{{ url('/api/webhooks/mercadopago') }}</code>
    </div>

    <form method="POST" action="{{ route('dev.integracoes.mercadopago.update') }}">
        @csrf
        @method('PUT')

        <div class="bo-card p-3 mb-3">
            <h6 class="mb-3">Credenciais</h6>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Public Key</label>
                    <input name="public_key" value="{{ old('public_key', $setting->public_key) }}"
                           class="form-control" placeholder="{{ $setting->public_key ? '' : '(usando .env)' }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Access Token</label>
                    <input name="access_token" type="password" class="form-control"
                           placeholder="{{ $setting->access_token ? App\Models\IntegrationSetting::maskSecret($setting->access_token) : '(usando .env)' }}"
                           autocomplete="new-password">
                    <div class="form-text">Deixe em branco pra manter o valor salvo.</div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Client ID</label>
                    <input name="client_id" value="{{ old('client_id', $setting->client_id) }}" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Client Secret</label>
                    <input name="client_secret" type="password" class="form-control"
                           placeholder="{{ $setting->client_secret ? App\Models\IntegrationSetting::maskSecret($setting->client_secret) : '' }}"
                           autocomplete="new-password">
                    <div class="form-text">Deixe em branco pra manter o valor salvo.</div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Webhook Secret (assinatura HMAC)</label>
                    <input name="webhook_secret" type="password" class="form-control"
                           placeholder="{{ $setting->webhook_secret ? App\Models\IntegrationSetting::maskSecret($setting->webhook_secret) : '(usando .env)' }}"
                           autocomplete="new-password">
                    <div class="form-text">Deixe em branco pra manter o valor salvo.</div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">URL de notificação cadastrada no Mercado Pago</label>
                    <input name="notification_url" value="{{ old('notification_url', $setting->notification_url) }}"
                           class="form-control" placeholder="https://...">
                    <div class="form-text">Só anotação/referência — o endpoint real é o mostrado acima.</div>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">
            <i class="bi bi-check2"></i> Salvar
        </button>
    </form>

    @if ($setting->exists)
        <p class="text-muted small mt-3">
            Última atualização: {{ $setting->updated_at?->format('d/m/Y H:i') }}
            @if ($setting->updatedBy) por {{ $setting->updatedBy->name }} @endif
        </p>
    @endif
@endsection
