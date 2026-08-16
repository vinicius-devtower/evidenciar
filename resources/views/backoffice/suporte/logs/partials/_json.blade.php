@php
    /**
     * $data pode ser array, objeto ou string com JSON. Renderiza bonitinho.
     */
    $pretty = null;
    if (is_array($data) || is_object($data)) {
        $pretty = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    } elseif (is_string($data)) {
        $decoded = json_decode($data, true);
        $pretty  = is_array($decoded)
            ? json_encode($decoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
            : $data;
    }
@endphp
<pre style="background:#1a1a1a; color:#edece1; padding:14px; border-radius:6px; font-size:12px; max-height:480px; overflow:auto;">{{ $pretty ?? '—' }}</pre>
