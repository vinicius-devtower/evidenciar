@extends('layouts.jornada')
@section('title', 'Passo 2 · Domínio')

@section('sidebar')
    <p><strong>Agora vamos falar</strong><br>sobre o domínio do seu site.</p>
    <p>Você pode usar um domínio que já tem<br>ou registrar um novo.</p>
@endsection

@section('content')
    @include('jornada._plan-ribbon')

    <div class="ev-stepper">
        <span class="ev-step is-done">
            <span class="check">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
            </span>
            Passo 01
        </span>
        <span class="ev-step is-active">Passo 02</span>
        <span class="ev-step is-pending">Passo 03</span>
    </div>

    @php
        $dominioOpcao = old('dominio_opcao', $data['step2']['dominio_opcao'] ?? '');
        $dominioValor = old('dominio', $data['step2']['dominio'] ?? '');
    @endphp

    <form method="POST" action="{{ route('jornada.step2.save') }}">
        @csrf

        <div class="ev-field">
            <label class="ev-label">Escolha uma das opções abaixo:</label>
            <div class="ev-pill-grid" style="grid-template-columns: repeat(3, minmax(0, 1fr));" id="dominio-pills">
                <label class="ev-pill {{ $dominioOpcao === 'possuo' ? 'is-selected' : '' }}">
                    <input type="radio" name="dominio_opcao" value="possuo" class="d-none"
                           {{ $dominioOpcao === 'possuo' ? 'checked' : '' }}>
                    Já possuo um domínio
                </label>
                <label class="ev-pill {{ $dominioOpcao === 'registrar' ? 'is-selected' : '' }}">
                    <input type="radio" name="dominio_opcao" value="registrar" class="d-none"
                           {{ $dominioOpcao === 'registrar' ? 'checked' : '' }}>
                    Registrar novo domínio
                </label>
                <label class="ev-pill {{ $dominioOpcao === 'sem_dominio' ? 'is-selected' : '' }}">
                    <input type="radio" name="dominio_opcao" value="sem_dominio" class="d-none"
                           {{ $dominioOpcao === 'sem_dominio' ? 'checked' : '' }}>
                    Decidir depois
                </label>
            </div>
        </div>

        <div id="dominio-input" class="ev-field" style="{{ in_array($dominioOpcao, ['possuo','registrar']) ? '' : 'display:none;' }}">
            <label for="dominio" class="ev-label">Qual o domínio de sua preferência?</label>
            <input type="text" id="dominio" name="dominio" class="ev-input"
                   value="{{ $dominioValor }}"
                   placeholder="Ex: meuescritorio.adv.br">
            <span class="ev-help">Não precisa ser o definitivo — você pode ajustar depois no painel.</span>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-4">
            <a href="{{ route('jornada.step1') }}" class="btn-ev-ghost">← Voltar</a>
            <button type="submit" class="btn-ev">Próximo Passo</button>
        </div>
    </form>

    <script>
        (function(){
            const pills = document.querySelectorAll('#dominio-pills .ev-pill');
            const input = document.getElementById('dominio-input');
            pills.forEach(pill => {
                pill.addEventListener('click', e => {
                    if (e.target.tagName !== 'INPUT') {
                        e.preventDefault();
                        const radio = pill.querySelector('input[type="radio"]');
                        radio.checked = true;
                        pills.forEach(p => p.classList.toggle('is-selected', p.querySelector('input[type="radio"]').checked));
                        input.style.display = (radio.value === 'sem_dominio') ? 'none' : '';
                    }
                });
            });
        })();
    </script>
@endsection
