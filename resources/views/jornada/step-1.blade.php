@extends('layouts.jornada')
@section('title', 'Passo 1 · Informações iniciais')

@section('sidebar')
    <p><strong>Para iniciar o seu site,</strong><br>preciso de algumas rápidas informações:</p>
@endsection

@section('content')
    @include('jornada._plan-ribbon')

    {{-- Stepper --}}
    <div class="ev-stepper">
        <span class="ev-step is-active">Passo 01</span>
        <span class="ev-step is-pending">Passo 02</span>
        <span class="ev-step is-pending">Passo 03</span>
    </div>

    <form method="POST" action="{{ route('jornada.step1.save') }}">
        @csrf

        {{-- Segmento --}}
        <div class="ev-field">
            <label for="area_atuacao" class="ev-label">Qual seu Segmento?</label>
            <input type="text" id="area_atuacao" name="area_atuacao"
                   class="ev-input"
                   value="{{ old('area_atuacao', $data['step1']['area_atuacao'] ?? '') }}"
                   placeholder="Ex: Advocacia"
                   required>
            @error('area_atuacao') <span class="ev-error">{{ $message }}</span> @enderror
        </div>

        {{-- Especialidade --}}
        <div class="ev-field">
            <label for="especialidade" class="ev-label">Qual sua especialidade?</label>
            <input type="text" id="especialidade" name="especialidade"
                   class="ev-input"
                   value="{{ old('especialidade', $data['step1']['especialidade'] ?? '') }}"
                   placeholder="Ex: Trabalhista">
            @error('especialidade') <span class="ev-error">{{ $message }}</span> @enderror
        </div>

        {{-- Categorias --}}
        <div class="ev-field">
            <label class="ev-label">Escolha até 5 categorias do seu segmento</label>
            <div class="ev-pill-grid" id="categorias">
                @php
                    $selected = old('categorias', $data['step1']['categorias'] ?? []);
                    $options = ['Trabalhista','Criminalista','Serviços','Civil','Ambiental','Empresarial','Tributário','Contratual'];
                @endphp
                @foreach ($options as $cat)
                    <label class="ev-pill {{ in_array($cat, $selected) ? 'is-selected' : '' }}">
                        <input type="checkbox" name="categorias[]" value="{{ $cat }}"
                               class="d-none"
                               {{ in_array($cat, $selected) ? 'checked' : '' }}>
                        {{ $cat }}
                    </label>
                @endforeach
            </div>
            <span class="ev-help">Você pode selecionar múltiplas categorias que representem sua atuação.</span>
        </div>

        <div class="d-flex justify-content-end mt-4">
            <button type="submit" class="btn-ev">Próximo Passo</button>
        </div>
    </form>

    <script>
        // Toggle com limite de 5 seleções.
        const MAX_SELECT = 5;
        document.querySelectorAll('#categorias .ev-pill').forEach(pill => {
            pill.addEventListener('click', (e) => {
                if (e.target.tagName !== 'INPUT') {
                    e.preventDefault();
                    const input = pill.querySelector('input');
                    const current = document.querySelectorAll('#categorias input:checked').length;
                    if (!input.checked && current >= MAX_SELECT) return;
                    input.checked = !input.checked;
                }
                pill.classList.toggle('is-selected', pill.querySelector('input').checked);
            });
        });
    </script>
@endsection
