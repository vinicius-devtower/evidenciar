@php
    $current = $current ?? 1;
    $items = [
        1 => 'Domínio',
        2 => 'Dados',
        3 => 'Checklist',
        4 => 'Revisar',
    ];
@endphp
<div class="d-flex align-items-center gap-3 mb-4" style="flex-wrap:wrap;">
    @foreach ($items as $n => $label)
        @php
            $state = $n < $current ? 'done' : ($n === $current ? 'current' : 'future');
            $bg = $state === 'done' ? '#21883a' : ($state === 'current' ? '#1a1a1a' : '#e5e5e0');
            $fg = $state === 'future' ? '#888' : '#fff';
        @endphp
        <div class="d-flex align-items-center gap-2" style="font-size:13px;">
            <span style="width:24px; height:24px; border-radius:50%; background:{{ $bg }}; color:{{ $fg }};
                         display:inline-flex; align-items:center; justify-content:center; font-weight:700;">
                {{ $n }}
            </span>
            <span style="{{ $state === 'future' ? 'color:#888;' : '' }}">{{ $label }}</span>
        </div>
        @if (!$loop->last)
            <div style="flex:1; max-width:40px; height:1px; background:#e5e5e0;"></div>
        @endif
    @endforeach
</div>
