@php
    // Espera: $channel, $title, $data, $hasMsg (bool), $valuePlaceholder, $msgPlaceholder (opcional)
    $enabled = (bool)($data['enabled'] ?? false);
    $value   = (string)($data['value'] ?? '');
    $message = (string)($data['message'] ?? '');
@endphp

<div class="contato-card {{ $enabled ? '' : 'is-disabled' }}"
     data-contact-card="{{ $channel }}">

    <div class="d-flex align-items-center justify-content-between">
        <label>{{ $title }}</label>
        <span class="ct-badge {{ $enabled ? 'on' : 'off' }}">
            {{ $enabled ? 'Ativo' : 'Desativado' }}
        </span>
    </div>

    <input type="text"
           class="form-control"
           name="contacts[{{ $channel }}][value]"
           value="{{ $value }}"
           placeholder="{{ $valuePlaceholder ?? '' }}">

    @if (!empty($hasMsg))
        <textarea class="form-control"
                  rows="3"
                  name="contacts[{{ $channel }}][message]"
                  placeholder="{{ $msgPlaceholder ?? 'Mensagem padrão' }}">{{ $message }}</textarea>
    @endif

    <input type="hidden"
           name="contacts[{{ $channel }}][enabled]"
           value="{{ $enabled ? 1 : 0 }}"
           data-contact-enabled="{{ $channel }}">

    <div class="ct-actions">
        <button type="button"
                class="btn ct-btn-on"
                data-contact-toggle="{{ $channel }}"
                data-enable="1">
            Ativar
        </button>
        <button type="button"
                class="btn ct-btn-off"
                data-contact-toggle="{{ $channel }}"
                data-enable="0">
            Desativar
        </button>
    </div>
</div>
