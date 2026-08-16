@extends('layouts.jornada')
@section('title', 'Aguardando pagamento')

@push('head')
    <meta http-equiv="refresh" content="15">
@endpush

@section('sidebar')
    @if($payment->isPix())
        <p><strong>Seu PIX está pronto!</strong></p>
    @elseif($payment->isBoleto())
        <p><strong>Seu boleto foi gerado!</strong></p>
    @else
        <p><strong>Pagamento em análise</strong></p>
    @endif

    <p>Enviei as instruções para <strong>{{ $payment->email }}</strong>.</p>
    <p>Assim que o pagamento cair, seu acesso é liberado automaticamente.</p>
@endsection

@section('content')
    <div class="ev-stepper">
        <span class="ev-step is-done">
            <span class="check">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
            </span>
            Passo 01
        </span>
        <span class="ev-step is-done">
            <span class="check">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
            </span>
            Passo 02
        </span>
        <span class="ev-step is-active">Passo 03</span>
    </div>

    @php
        $title = $payment->isPix()    ? 'Pague com PIX para liberar seu site'
               : ($payment->isBoleto() ? 'Pague o boleto para liberar seu site'
               : 'Estamos processando seu pagamento');
        $intro = $payment->isPix()
              ? 'Escaneie o QR Code abaixo com o app do seu banco ou copie o código PIX.'
              : ($payment->isBoleto()
                    ? 'Use o código de barras abaixo ou abra o boleto em PDF.'
                    : 'Assim que a operadora confirmar, seu acesso é liberado automaticamente.');
    @endphp

    <h3 style="font-size:20px; font-weight:700; color: var(--ev-ink); margin-bottom:6px;">
        {{ $title }}
    </h3>
    <p style="color: var(--ev-muted); font-size:14px; margin-bottom:24px;">
        {{ $intro }}
    </p>

    <div class="row g-4 align-items-center"
         style="background:#fff; border:1px solid var(--ev-border); border-radius:14px; padding:24px; margin-bottom:20px;">

        @if($payment->isPix())
            {{-- ============= PIX ============= --}}
            <div class="col-md-5 text-center">
                @if($payment->qr_code_base64)
                    <img src="data:image/png;base64,{{ $payment->qr_code_base64 }}"
                         alt="QR Code PIX"
                         style="max-width:220px; border-radius:10px; background:#fff; padding:8px;">
                @else
                    <div style="background:#f1f3f6; border-radius:10px; padding:60px 20px; color:var(--ev-muted); font-style:italic;">
                        QR-CODE indisponível.<br>Use o código abaixo.
                    </div>
                @endif
            </div>

            <div class="col-md-7">
                <div style="font-size:13px; color: var(--ev-muted); text-transform:uppercase; letter-spacing:1px; font-weight:600;">Valor</div>
                <div style="font-size:22px; font-weight:700; color: var(--ev-ink); margin-bottom:14px;">
                    R$ {{ number_format($payment->amount, 2, ',', '.') }}
                </div>

                <div style="font-size:13px; color: var(--ev-muted);">Expira em:</div>
                <div style="font-size:14px; font-weight:500; color: var(--ev-ink); margin-bottom:16px;">
                    @if($payment->expires_at)
                        {{ \Carbon\Carbon::parse($payment->expires_at)->format('d/m/Y H:i') }}
                    @else
                        30 minutos
                    @endif
                </div>

                <label class="ev-label" style="margin-bottom:6px; font-size:12.5px;">Código copia-e-cola</label>
                <div class="d-flex gap-2">
                    <input type="text" class="ev-input" readonly
                           id="pix-copy-paste"
                           value="{{ $payment->qr_code ?? '' }}"
                           style="height:48px; font-size:12px;">
                    <button class="btn-ev" type="button" onclick="copyField('pix-copy-paste')" style="flex-shrink:0;">Copiar</button>
                </div>
            </div>

        @elseif($payment->isBoleto())
            {{-- ============= Boleto ============= --}}
            <div class="col-md-12">
                <div style="font-size:13px; color: var(--ev-muted); text-transform:uppercase; letter-spacing:1px; font-weight:600;">Valor</div>
                <div style="font-size:22px; font-weight:700; color: var(--ev-ink); margin-bottom:14px;">
                    R$ {{ number_format($payment->amount, 2, ',', '.') }}
                </div>

                <div style="font-size:13px; color: var(--ev-muted);">Vencimento:</div>
                <div style="font-size:14px; font-weight:500; color: var(--ev-ink); margin-bottom:16px;">
                    @if($payment->expires_at)
                        {{ \Carbon\Carbon::parse($payment->expires_at)->format('d/m/Y') }}
                    @else
                        3 dias úteis
                    @endif
                </div>

                @if($payment->boleto_line)
                    <label class="ev-label" style="margin-bottom:6px; font-size:12.5px;">Linha digitável</label>
                    <div class="d-flex gap-2 mb-3">
                        <input type="text" class="ev-input" readonly
                               id="boleto-line"
                               value="{{ $payment->boleto_line }}"
                               style="height:48px; font-size:12px;">
                        <button class="btn-ev" type="button" onclick="copyField('boleto-line')" style="flex-shrink:0;">Copiar</button>
                    </div>
                @endif

                @if($payment->boleto_url)
                    <a href="{{ $payment->boleto_url }}" target="_blank" rel="noopener"
                       class="btn-ev" style="display:inline-flex;">
                        Abrir boleto em PDF ↗
                    </a>
                @endif
            </div>

        @else
            {{-- ============= Cartão (processando) ============= --}}
            <div class="col-md-12">
                <div style="font-size:13px; color: var(--ev-muted); text-transform:uppercase; letter-spacing:1px; font-weight:600;">Valor</div>
                <div style="font-size:22px; font-weight:700; color: var(--ev-ink); margin-bottom:14px;">
                    R$ {{ number_format($payment->amount, 2, ',', '.') }}
                    @if($payment->installments) <small style="font-size:13px; color:var(--ev-muted);">em {{ $payment->installments }}x</small>@endif
                </div>

                <div style="font-size:13px; color: var(--ev-muted);">Cartão:</div>
                <div style="font-size:14px; font-weight:500; color: var(--ev-ink); margin-bottom:16px;">
                    {{ strtoupper($payment->card_brand ?? 'Cartão') }} •••• {{ $payment->card_last4 ?? '' }}
                </div>

                <p style="color: var(--ev-muted); font-size:13.5px;">
                    Sua transação está em análise pela operadora. Esta página recarrega a cada 15s.
                </p>
            </div>
        @endif
    </div>

    <div class="alert alert-info">
        Enviamos as instruções para <strong>{{ $payment->email }}</strong>.
        Esta página recarrega automaticamente a cada 15s; assim que o pagamento for confirmado, você será redirecionado.
    </div>

    <div style="color: var(--ev-muted); font-size:12px;">
        ID do pagamento: <code>{{ $payment->external_id }}</code>
    </div>

    <script>
        function copyField(id){
            const el = document.getElementById(id);
            if (!el) return;
            el.select(); el.setSelectionRange(0, 99999);
            navigator.clipboard.writeText(el.value);
            alert('Copiado!');
        }
    </script>
@endsection
