@extends('layouts.sistema')
@section('title', 'Solicitar publicação — Passo 2')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        @include('sistema.publicacao.wizard._steps', ['current' => 2])

        <div class="bo-card p-4" style="background:#fff; border:1px solid #e5e5e0; border-radius:6px;">

            @if ($draft['has_domain'] === 'yes')
                <h4>Conte-nos sobre o seu domínio</h4>
                <p class="text-muted small">
                    Precisamos do nome do domínio e, se possível, onde foi registrado.
                    O suporte vai pedir as credenciais pela thread de mensagens (nunca compartilhe aqui).
                </p>

                <form method="POST" action="{{ route('app.publicacao.wizard.step2.save') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nome do domínio</label>
                        <input name="domain_name" required class="form-control"
                               placeholder="ex: minhaempresa.com.br"
                               value="{{ old('domain_name', $draft['domain_name'] ?? '') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Onde foi registrado? <small class="text-muted">(opcional)</small></label>
                        <input name="registrar" class="form-control"
                               placeholder="ex: Registro.br, GoDaddy, Hostgator..."
                               value="{{ old('registrar', $draft['registrar'] ?? '') }}">
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Observações adicionais <small class="text-muted">(opcional)</small></label>
                        <textarea name="access_notes" rows="3" class="form-control"
                                  placeholder="Algo que o suporte deve saber? Ex: o domínio já aponta para outro site."
                        >{{ old('access_notes', $draft['access_notes'] ?? '') }}</textarea>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('app.publicacao.wizard.step1') }}" class="btn btn-outline-dark">Voltar</a>
                        <button class="btn btn-dark">Continuar</button>
                    </div>
                </form>
            @else
                <h4>Qual domínio você gostaria de registrar?</h4>
                <p class="text-muted small">
                    Nossos times te ajudam a escolher e orientar sobre o registro. Para sites no Brasil,
                    recomendamos <code>.com.br</code> (registrado no Registro.br).
                </p>

                <form method="POST" action="{{ route('app.publicacao.wizard.step2.save') }}">
                    @csrf
                    <div class="row g-2 mb-3">
                        <div class="col-md-8">
                            <label class="form-label">Nome desejado</label>
                            <input name="desired_domain" required class="form-control"
                                   placeholder="ex: minhaempresa"
                                   value="{{ old('desired_domain', $draft['desired_domain'] ?? '') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Extensão</label>
                            <select name="extension" class="form-select" required>
                                @foreach (['.com.br', '.com', 'outro'] as $ext)
                                    <option value="{{ $ext }}"
                                        {{ ($draft['extension'] ?? '.com.br') === $ext ? 'selected' : '' }}>
                                        {{ $ext }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Quer que o suporte faça o registro para você?</label>
                        <div class="d-flex gap-3">
                            <label class="form-check-label">
                                <input type="radio" name="register_help" value="yes" required
                                    {{ ($draft['register_help'] ?? '') === 'yes' ? 'checked' : '' }}>
                                Sim, me ajude com o registro
                            </label>
                            <label class="form-check-label">
                                <input type="radio" name="register_help" value="no" required
                                    {{ ($draft['register_help'] ?? '') === 'no' ? 'checked' : '' }}>
                                Não, eu mesmo registro
                            </label>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Observações adicionais <small class="text-muted">(opcional)</small></label>
                        <textarea name="access_notes" rows="3" class="form-control"
                        >{{ old('access_notes', $draft['access_notes'] ?? '') }}</textarea>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('app.publicacao.wizard.step1') }}" class="btn btn-outline-dark">Voltar</a>
                        <button class="btn btn-dark">Continuar</button>
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection
