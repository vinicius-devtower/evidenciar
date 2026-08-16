@extends('layouts.sistema')

@section('title', 'Conta — Evidenciar')

@section('content')
<div class="conta">

    <div class="conta-header text-center mb-5">
        <h3>Conta</h3>
        <p>Gerencie suas informações</p>
    </div>

    <div class="row g-4">

        <!-- INFORMAÇÕES -->
        <div class="col-md-4">
            <div class="conta-box">
                <h6>Informações da Conta</h6>

                <p><strong>Empresa:</strong><br>{{ $client->name ?? '—' }}</p>
                <p><strong>Documento:</strong><br>{{ $client->document ?? '—' }}</p>
                <p><strong>Status:</strong><br>{{ $client->status ?? '—' }}</p>
            </div>
        </div>

        <!-- RESPONSÁVEL -->
        <div class="col-md-4">
            <div class="conta-box">
                <h6>Responsável</h6>

                <p><strong>Nome:</strong><br>{{ $user->name }}</p>
                <p><strong>Email:</strong><br>{{ $user->email }}</p>

                <a href="{{ route('profile.edit') }}" class="btn btn-green mt-2">
                    Editar
                </a>
            </div>
        </div>

        <!-- PLANO -->
        <div class="col-md-4">
            <div class="conta-box">
                <h6>Plano</h6>

                @if ($subscription)
                    <p><strong>Plano:</strong><br>
                        {{ optional($subscription->plan)->name ?? ($subscription->plan_name ?? '—') }}
                        @if(optional($subscription->plan)->priceFormatted())
                            <br><small class="text-muted">{{ $subscription->plan->priceFormatted() }}/mês</small>
                        @endif
                    </p>
                    <p><strong>Status:</strong><br>
                        <span class="text-success">{{ ucfirst($subscription->status) }}</span>
                    </p>
                    <p><strong>Início:</strong><br>
                        {{ $subscription->started_at?->format('d/m/Y') ?? '—' }}
                    </p>
                    @if($subscription->payment_method)
                        <p><strong>Pagamento:</strong><br>
                            {{ ['pix' => 'PIX', 'boleto' => 'Boleto', 'credit_card' => 'Cartão de crédito'][$subscription->payment_method] ?? $subscription->payment_method }}
                        </p>
                    @endif
                @else
                    <p>Sem plano ativo.</p>
                @endif
            </div>
        </div>

    </div>

</div>
@endsection
