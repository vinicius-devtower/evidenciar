@php
    // Shape: $contactG = [
    //   'whatsapp'  => ['enabled' => bool, 'value' => '...', 'message' => '...'],
    //   'email'     => ['enabled' => bool, 'value' => '...', 'message' => '...'],
    //   'instagram' => ['enabled' => bool, 'value' => '...'],
    //   'facebook'  => ['enabled' => bool, 'value' => '...'],
    //   'linkedin'  => ['enabled' => bool, 'value' => '...'],
    //   'x'         => ['enabled' => bool, 'value' => '...'],
    //   'phone'     => ['enabled' => bool, 'value' => '...'],
    // ]
    // Backward-compat com shape antigo (strings soltas): normaliza abaixo.
    $raw = $contactG ?? [];

    $pick = function (string $k) use ($raw) {
        $v = $raw[$k] ?? null;
        if (is_array($v)) {
            return [
                'enabled' => (bool)($v['enabled'] ?? false),
                'value'   => (string)($v['value'] ?? ''),
                'message' => (string)($v['message'] ?? ''),
            ];
        }
        // string legacy -> liga se não for vazio
        return [
            'enabled' => filled($v),
            'value'   => (string)($v ?? ''),
            'message' => '',
        ];
    };

    $whatsapp  = $pick('whatsapp');
    $email     = $pick('email');
    $instagram = $pick('instagram');
    $facebook  = $pick('facebook');
    $linkedin  = $pick('linkedin');
    $x         = $pick('x');
    $phone     = $pick('phone');
@endphp

<style>
.contato-card {
    background: #fff;
    border: 1px solid rgba(19,45,70,.08);
    border-radius: 8px;
    padding: 12px;
    display: flex;
    flex-direction: column;
    gap: 8px;
    height: 100%;
}
.contato-card label {
    font-size: 12px;
    font-weight: 700;
    color: #132d46;
    text-transform: uppercase;
    letter-spacing: .4px;
    margin: 0;
}
.contato-card .form-control {
    background: #f7f6ed;
    border: 1px solid rgba(19,45,70,.08);
    border-radius: 6px;
    font-size: 13px;
    padding: 8px 10px;
    height: auto;
    color: #132d46;
}
.contato-card textarea.form-control { min-height: 72px; }
.contato-card .ct-actions {
    display: flex;
    gap: 6px;
    margin-top: auto;
}
.contato-card .ct-actions .btn {
    flex: 1;
    font-size: 12px;
    font-weight: 700;
    padding: 7px 10px;
    border-radius: 6px;
}
.ct-btn-on {
    background: var(--cor-azul-medio);
    color: #fff;
    border: none;
}
.ct-btn-on:hover { background: var(--cor-azul-escuro); color: #fff; }
.ct-btn-off {
    background: #c94a4a;
    color: #fff;
    border: none;
}
.ct-btn-off:hover { background: #a93939; color: #fff; }
.contato-card.is-disabled {
    opacity: .55;
    background: rgba(237,236,225,.45);
}
.contato-card.is-disabled .form-control { background: #efefef; }
.ct-badge {
    font-size: 10px;
    font-weight: 700;
    padding: 2px 7px;
    border-radius: 999px;
    letter-spacing: .4px;
    text-transform: uppercase;
    color: #fff;
}
.ct-badge.on  { background: var(--cor-verde); }
.ct-badge.off { background: #8b919b; }
</style>

<div class="modal fade modal-brand" id="modalContato" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <form method="POST" action="{{ route('app.contact-global.save') }}"
              class="modal-content" id="formContato">
            @csrf

            <div class="modal-header">
                <h5 class="modal-title">Contatos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="row g-3">

                    {{-- WhatsApp --}}
                    <div class="col-md-6 col-lg-4">
                        @include('sistema.partials.contato-card', [
                            'channel' => 'whatsapp',
                            'title'   => 'WhatsApp',
                            'data'    => $whatsapp,
                            'hasMsg'  => true,
                            'valuePlaceholder' => '+55 11 99999-9999',
                            'msgPlaceholder'   => 'Olá! Gostei do seu site e gostaria de saber mais sobre seus serviços. Podemos conversar?',
                        ])
                    </div>

                    {{-- E-mail --}}
                    <div class="col-md-6 col-lg-4">
                        @include('sistema.partials.contato-card', [
                            'channel' => 'email',
                            'title'   => 'E-mail',
                            'data'    => $email,
                            'hasMsg'  => true,
                            'valuePlaceholder' => 'contato@seudominio.com.br',
                            'msgPlaceholder'   => 'Olá! Gostei do seu site e gostaria de saber mais sobre seus serviços. Podemos conversar?',
                        ])
                    </div>

                    {{-- Instagram --}}
                    <div class="col-md-6 col-lg-4">
                        @include('sistema.partials.contato-card', [
                            'channel' => 'instagram',
                            'title'   => 'Instagram',
                            'data'    => $instagram,
                            'hasMsg'  => false,
                            'valuePlaceholder' => '@suaempresa',
                        ])
                    </div>

                    {{-- Facebook --}}
                    <div class="col-md-6 col-lg-4">
                        @include('sistema.partials.contato-card', [
                            'channel' => 'facebook',
                            'title'   => 'Facebook',
                            'data'    => $facebook,
                            'hasMsg'  => false,
                            'valuePlaceholder' => '/suaempresa',
                        ])
                    </div>

                    {{-- LinkedIn --}}
                    <div class="col-md-6 col-lg-4">
                        @include('sistema.partials.contato-card', [
                            'channel' => 'linkedin',
                            'title'   => 'LinkedIn',
                            'data'    => $linkedin,
                            'hasMsg'  => false,
                            'valuePlaceholder' => 'suaempresa',
                        ])
                    </div>

                    {{-- X --}}
                    <div class="col-md-6 col-lg-4">
                        @include('sistema.partials.contato-card', [
                            'channel' => 'x',
                            'title'   => 'X (Twitter)',
                            'data'    => $x,
                            'hasMsg'  => false,
                            'valuePlaceholder' => 'suaempresa',
                        ])
                    </div>

                    {{-- Telefone --}}
                    <div class="col-md-6 col-lg-4">
                        @include('sistema.partials.contato-card', [
                            'channel' => 'phone',
                            'title'   => 'Telefone / Celular',
                            'data'    => $phone,
                            'hasMsg'  => false,
                            'valuePlaceholder' => '(11) 99999-9999',
                        ])
                    </div>

                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-green" style="background:var(--cor-verde);color:#fff;border:none;">
                    Salvar contatos
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Toggle ativar/desativar por canal
document.querySelectorAll('[data-contact-toggle]').forEach(btn => {
    btn.addEventListener('click', () => {
        const channel = btn.dataset.contactToggle;
        const enabled = btn.dataset.enable === '1';
        const card    = document.querySelector(`[data-contact-card="${channel}"]`);
        const hidden  = document.querySelector(`[data-contact-enabled="${channel}"]`);
        if (!card || !hidden) return;
        hidden.value = enabled ? '1' : '0';
        card.classList.toggle('is-disabled', !enabled);
        const badge = card.querySelector('.ct-badge');
        if (badge) {
            badge.classList.toggle('on',  enabled);
            badge.classList.toggle('off', !enabled);
            badge.textContent = enabled ? 'Ativo' : 'Desativado';
        }
    });
});
</script>
