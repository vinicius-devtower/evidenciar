@php
    $tall   = $tall   ?? false;
    $small  = $small  ?? false;
    $square = $square ?? false;
    $extra  = '';
    if ($tall)   $extra .= ' sk-img--tall';
    if ($small)  $extra .= ' sk-img--small';
    if ($square) $extra .= ' sk-img--square';
@endphp
<div class="sk-img{{ $extra }}" role="img" aria-label="{{ $label }}">
    <svg viewBox="0 0 100 60" preserveAspectRatio="none" aria-hidden="true">
        <line x1="0" y1="0" x2="100" y2="60" stroke="currentColor" stroke-width="0.4" />
        <line x1="0" y1="60" x2="100" y2="0" stroke="currentColor" stroke-width="0.4" />
    </svg>
    <div class="sk-img__label">
        <strong>{{ $label }}</strong>
        @if (! empty($spec))
            <span>{{ $spec }}</span>
        @endif
    </div>
</div>
