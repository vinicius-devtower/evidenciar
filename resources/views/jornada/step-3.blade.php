@extends('layouts.jornada')
@section('title', 'Passo 3 · Seus dados')

@section('sidebar')
    <p><strong>Último passo!</strong></p>
    <p>Preciso dos seus dados e da forma<br>de pagamento para finalizar.</p>
    <p>Assim que o pagamento cair, seu acesso<br>é liberado automaticamente.</p>
@endsection

@push('head')
    <style>
        .ev-pay-tabs{
            display:grid;
            grid-template-columns: repeat(3, minmax(0,1fr));
            gap: 10px;
            margin-bottom: 18px;
        }
        .ev-pay-tab{
            border:1.5px solid var(--ev-border);
            background:#fff;
            border-radius:10px;
            padding: 14px 12px;
            text-align:center;
            cursor:pointer;
            font-weight:600; font-size:14px;
            color: var(--ev-muted);
            transition: all .15s;
            display:flex; flex-direction:column; align-items:center; gap:6px;
        }
        .ev-pay-tab:hover{ border-color: var(--ev-teal); color: var(--ev-teal); }
        .ev-pay-tab.is-selected{
            background: var(--ev-teal);
            color:#fff;
            border-color: var(--ev-teal);
        }
        .ev-pay-tab .ico{ font-size:22px; line-height:1; }
        .ev-pay-body{
            border:1px solid var(--ev-border);
            background:#fff;
            border-radius:10px;
            padding: 18px;
            margin-bottom: 22px;
        }
        .ev-pay-body p{ font-size:13.5px; color: var(--ev-muted); margin:0; }
        .ev-pay-body p strong{ color: var(--ev-ink); }
    </style>
@endpush

@section('content')
    @include('jornada._plan-ribbon')

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

    <form method="POST" action="{{ route('jornada.step3.save') }}" id="jornada-step3-form">
        @csrf

        {{-- ============= Dados pessoais ============= --}}
        <div class="ev-field">
            <label for="name" class="ev-label">Nome completo</label>
            <input type="text" id="name" name="name" class="ev-input"
                   value="{{ old('name', $data['step3']['name'] ?? '') }}"
                   placeholder="Seu nome completo" required>
        </div>

        <div class="row g-3">
            <div class="col-md-7 ev-field mb-0">
                <label for="email" class="ev-label">E-mail</label>
                <input type="email" id="email" name="email" class="ev-input"
                       value="{{ old('email', $data['step3']['email'] ?? '') }}"
                       placeholder="voce@dominio.com" required>
                <span class="ev-help">Link de acesso vai para este e-mail.</span>
            </div>
            <div class="col-md-5 ev-field mb-0">
                <label for="whatsapp" class="ev-label">WhatsApp / Contato</label>
                <input type="text" id="whatsapp" name="whatsapp" class="ev-input"
                       value="{{ old('whatsapp', $data['step3']['whatsapp'] ?? '') }}"
                       placeholder="(11) 99999-9999">
            </div>
        </div>

        <div class="ev-field mt-3">
            <label for="documento" class="ev-label">CPF / CNPJ</label>
            <input type="text" id="documento" name="documento" class="ev-input"
                   value="{{ old('documento', $data['step3']['documento'] ?? '') }}"
                   placeholder="Obrigatório para emissão do pagamento" required>
        </div>

        {{-- ============= Método de pagamento ============= --}}
        <h4 style="font-size:15px; font-weight:700; color: var(--ev-ink); margin: 28px 0 12px;">
            Forma de pagamento
        </h4>

        @php
            $selectedMethod = old('payment_method', $data['step3']['payment_method'] ?? 'pix');
        @endphp

        <input type="hidden" name="payment_method" id="payment_method" value="{{ $selectedMethod }}">

        <div class="ev-pay-tabs" id="pay-tabs">
            <div class="ev-pay-tab {{ $selectedMethod === 'pix' ? 'is-selected' : '' }}" data-method="pix">
                <span class="ico">⚡</span>
                <span>PIX</span>
            </div>
            <div class="ev-pay-tab {{ $selectedMethod === 'boleto' ? 'is-selected' : '' }}" data-method="boleto">
                <span class="ico">📄</span>
                <span>Boleto</span>
            </div>
            <div class="ev-pay-tab {{ $selectedMethod === 'credit_card' ? 'is-selected' : '' }}" data-method="credit_card">
                <span class="ico">💳</span>
                <span>Cartão</span>
            </div>
        </div>

        {{-- Bloco PIX --}}
        <div class="ev-pay-body" data-pay-body="pix" style="{{ $selectedMethod === 'pix' ? '' : 'display:none;' }}">
            <p>Geramos o <strong>QR Code PIX</strong> na próxima tela — pagamento confirmado em segundos e acesso liberado automaticamente.</p>
        </div>

        {{-- Bloco Boleto --}}
        <div class="ev-pay-body" data-pay-body="boleto" style="{{ $selectedMethod === 'boleto' ? '' : 'display:none;' }}">
            <p>Emitimos um <strong>boleto bancário</strong> com vencimento em 3 dias úteis. A confirmação leva até 2 dias úteis após o pagamento.</p>
        </div>

        {{-- Bloco Cartão --}}
        <div class="ev-pay-body" data-pay-body="credit_card" style="{{ $selectedMethod === 'credit_card' ? '' : 'display:none;' }}">
            <div class="row g-3">
                <div class="col-12">
                    <label for="card_number" class="ev-label">Número do cartão</label>
                    <input type="text" id="card_number" class="ev-input" placeholder="•••• •••• •••• ••••" autocomplete="cc-number" inputmode="numeric">
                </div>
                <div class="col-12">
                    <label for="card_holder" class="ev-label">Nome no cartão</label>
                    <input type="text" id="card_holder" class="ev-input" placeholder="Como está impresso no cartão" autocomplete="cc-name">
                </div>
                <div class="col-md-5">
                    <label for="card_expiry" class="ev-label">Validade (MM/AA)</label>
                    <input type="text" id="card_expiry" class="ev-input" placeholder="MM/AA" autocomplete="cc-exp" inputmode="numeric">
                </div>
                <div class="col-md-3">
                    <label for="card_cvv" class="ev-label">CVV</label>
                    <input type="text" id="card_cvv" class="ev-input" placeholder="•••" autocomplete="cc-csc" inputmode="numeric">
                </div>
                <div class="col-md-4">
                    <label for="installments" class="ev-label">Parcelas</label>
                    <select id="installments_select" class="ev-input" style="height:58px;">
                        <option value="1">1x sem juros</option>
                        <option value="2">2x sem juros</option>
                        <option value="3">3x sem juros</option>
                        <option value="6">6x sem juros</option>
                        <option value="12">12x sem juros</option>
                    </select>
                </div>
            </div>

            {{-- Campos ocultos preenchidos pelo SDK MP antes do submit --}}
            <input type="hidden" name="card_token"   id="card_token">
            <input type="hidden" name="card_last4"   id="card_last4">
            <input type="hidden" name="card_brand"   id="card_brand">
            <input type="hidden" name="installments" id="installments" value="1">

            <div id="card_error" class="ev-error" style="margin-top:10px; display:none;"></div>
        </div>

        {{-- ============= Aceite + submit ============= --}}
        <div class="ev-field" style="margin-bottom:16px;">
            <label style="display:flex; align-items:center; gap:10px; color:var(--ev-muted); font-size:13.5px; cursor:pointer;">
                <input type="checkbox" name="aceite" value="1" {{ old('aceite') ? 'checked' : '' }}
                       style="width:18px; height:18px; accent-color: var(--ev-green); cursor:pointer;" required>
                Li e aceito os <a href="#" style="color: var(--ev-teal);">termos de uso</a>
                e a <a href="#" style="color: var(--ev-teal);">política de privacidade</a>.
            </label>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-4">
            <a href="{{ route('jornada.step2') }}" class="btn-ev-ghost">← Voltar</a>
            <button type="submit" class="btn-ev" id="jornada-submit">
                Finalizar @if(!empty($plan)) — {{ $plan->priceFormatted() }} @endif
            </button>
        </div>
    </form>
@endsection

@push('scripts')
<script src="https://sdk.mercadopago.com/js/v2"></script>
<script>
    (function(){
        // -------------------------------------------------
        // Alterna entre as abas de forma de pagamento
        // -------------------------------------------------
        const tabs = document.querySelectorAll('#pay-tabs .ev-pay-tab');
        const methodInput = document.getElementById('payment_method');
        const bodies = document.querySelectorAll('[data-pay-body]');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                tabs.forEach(t => t.classList.remove('is-selected'));
                tab.classList.add('is-selected');
                const method = tab.dataset.method;
                methodInput.value = method;
                bodies.forEach(b => b.style.display = (b.dataset.payBody === method) ? '' : 'none');
            });
        });

        // -------------------------------------------------
        // Mercado Pago SDK — tokeniza o cartão antes do submit
        // -------------------------------------------------
        @php $mpPublicKey = config('mercadopago.public_key'); @endphp
        @if($mpPublicKey)
            const mp = new MercadoPago('{{ $mpPublicKey }}');
            const instSelect = document.getElementById('installments_select');
            const instHidden = document.getElementById('installments');
            instSelect?.addEventListener('change', () => instHidden.value = instSelect.value);

            const form = document.getElementById('jornada-step3-form');
            const errorBox = document.getElementById('card_error');

            form.addEventListener('submit', async function (e) {
                if (methodInput.value !== 'credit_card') return; // PIX/boleto passam direto

                // Se já temos token (submit reentrante), deixa passar
                if (document.getElementById('card_token').value) return;

                e.preventDefault();
                errorBox.style.display = 'none';

                const number = document.getElementById('card_number').value.replace(/\s+/g,'');
                const holder = document.getElementById('card_holder').value;
                const [mm, yy] = (document.getElementById('card_expiry').value || '').split('/');
                const cvv    = document.getElementById('card_cvv').value;
                const doc    = (document.getElementById('documento').value || '').replace(/\D/g,'');

                try {
                    const tokenResp = await mp.createCardToken({
                        cardNumber:          number,
                        cardholderName:      holder,
                        cardExpirationMonth: (mm || '').trim(),
                        cardExpirationYear:  '20' + (yy || '').trim(),
                        securityCode:        cvv,
                        identificationType:  doc.length === 14 ? 'CNPJ' : 'CPF',
                        identificationNumber: doc,
                    });
                    document.getElementById('card_token').value = tokenResp.id;
                    document.getElementById('card_last4').value = number.slice(-4);

                    // Bandeira simples por prefixo (MP reconhece depois).
                    const brand = number.startsWith('4') ? 'visa'
                                : number.startsWith('5') ? 'master'
                                : number.startsWith('3') ? 'amex'
                                : 'visa';
                    document.getElementById('card_brand').value = brand;

                    form.submit();
                } catch (err) {
                    errorBox.style.display = 'block';
                    errorBox.textContent = 'Não foi possível validar o cartão. Verifique os dados e tente novamente.';
                    console.error(err);
                }
            });
        @else
            console.warn('MP_PUBLIC_KEY não configurada — cartão funcionará apenas em homologação manual.');
        @endif
    })();
</script>
@endpush
