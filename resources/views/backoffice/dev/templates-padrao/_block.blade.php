{{-- Renderiza um bloco do briefing: sketch + campos + imagens + notas --}}
<article class="tp-block">
    <header class="tp-block__head">
        <div>
            <h3 class="tp-block__name">{{ $block['name'] }}</h3>
            <p class="tp-block__desc">{{ $block['description'] }}</p>
        </div>
        <span class="tp-block__chip">bloco: {{ $block['id'] }}</span>
    </header>

    <div class="tp-block__sketch">
        @include('backoffice.dev.templates-padrao._sketches', ['sketch' => $block['sketch']])
    </div>

    <div class="tp-block__meta">
        @if (!empty($block['fields']))
            <div class="tp-meta">
                <h4 class="tp-meta__title"><i class="bi bi-text-paragraph me-1"></i> Campos editáveis</h4>
                <table class="tp-fields">
                    <thead>
                        <tr><th>Tag</th><th>Campo</th><th>Limite / Tipo</th><th class="text-end">Obrig.</th></tr>
                    </thead>
                    <tbody>
                        @foreach ($block['fields'] as $f)
                            @php
                                $tag = $f['tag'] ?? '?';
                                $tagClass = 'tp-tag tp-tag--' . strtolower($tag);
                                $limit = $f['max'] ?? null;
                                $spec = $f['spec'] ?? null;
                                $lines = $f['lines'] ?? null;
                            @endphp
                            <tr>
                                <td><span class="{{ $tagClass }}">{{ $tag }}</span></td>
                                <td>{{ $f['label'] }}</td>
                                <td class="text-muted small">
                                    @if ($limit) max {{ $limit }} char @endif
                                    @if ($lines) · {{ $lines }} linhas @endif
                                    @if ($spec) {{ $limit ? '· ' : '' }}{{ $spec }} @endif
                                    @if (! $limit && ! $spec) — @endif
                                </td>
                                <td class="text-end">
                                    @if (! empty($f['required']))
                                        <span class="tp-badge tp-badge--req">obrigatório</span>
                                    @else
                                        <span class="text-muted small">opcional</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        @if (!empty($block['images']))
            <div class="tp-meta">
                <h4 class="tp-meta__title"><i class="bi bi-image me-1"></i> Áreas de imagem</h4>
                <table class="tp-fields">
                    <thead>
                        <tr><th>Label</th><th>Dimensões sugeridas</th><th>Formato</th><th class="text-end">Alt</th></tr>
                    </thead>
                    <tbody>
                        @foreach ($block['images'] as $img)
                            <tr>
                                <td>{{ $img['label'] }}</td>
                                <td class="text-muted small">{{ $img['dimensions'] ?? '—' }}</td>
                                <td class="text-muted small">{{ $img['format'] ?? '—' }}</td>
                                <td class="text-end">
                                    @if (! empty($img['alt']))
                                        <span class="tp-badge tp-badge--req">obrigatório</span>
                                    @else
                                        <span class="text-muted small">recomendado</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        @if (!empty($block['notes']))
            <div class="tp-meta tp-notes">
                <h4 class="tp-meta__title"><i class="bi bi-lightbulb me-1"></i> Notas</h4>
                <ul class="mb-0">
                    @foreach ($block['notes'] as $n)
                        <li>{{ $n }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</article>
