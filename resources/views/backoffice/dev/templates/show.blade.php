@extends('layouts.backoffice')
@section('title', 'Template: '.$template->name)

@section('content')
    <a href="{{ route('dev.templates.index') }}" class="text-muted small text-decoration-none">← voltar</a>
    <h1 class="page-title mb-1">{{ $template->name }}</h1>
    <p class="page-sub">
        <code>{{ $template->slug }}</code>
        · versões: {{ $template->versions->count() }}
    </p>

    <div class="row g-3">
        <div class="col-md-6">
            <div class="bo-card">
                <div class="card-header">Versões</div>
                <div class="table-responsive">
                    <table class="table mb-0 small">
                        <thead><tr><th>Versão</th><th>Path</th><th>Status</th><th></th></tr></thead>
                        <tbody>
                            @foreach ($template->versions as $v)
                                <tr>
                                    <td>v{{ $v->version }}</td>
                                    <td><code>{{ $v->path }}</code></td>
                                    <td>
                                        @if ($v->is_active)
                                            <span class="badge bg-success">Ativa</span>
                                        @else
                                            <span class="badge bg-secondary">Inativa</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        @if (!$v->is_active)
                                            <form method="POST"
                                                  action="{{ route('dev.templates.versions.activate', [$template, $v]) }}">
                                                @csrf
                                                <button class="btn btn-sm btn-dark">Ativar</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bo-card mt-3">
                <div class="card-header">Planos em que aparece</div>
                <div class="p-3">
                    <form method="POST" action="{{ route('dev.templates.plans.sync', $template) }}">
                        @csrf
                        @forelse ($plans as $p)
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="plan-{{ $p->id }}"
                                       name="plan_ids[]" value="{{ $p->id }}"
                                       {{ $template->plans->contains($p->id) ? 'checked' : '' }}>
                                <label for="plan-{{ $p->id }}" class="form-check-label">
                                    {{ $p->name }}
                                    <small class="text-muted">· {{ $p->priceFormatted() }}</small>
                                </label>
                            </div>
                        @empty
                            <div class="small text-muted">
                                Nenhum plano cadastrado. <a href="{{ route('dev.planos.create') }}">Criar agora.</a>
                            </div>
                        @endforelse
                        @if ($plans->isNotEmpty())
                            <button class="btn btn-sm btn-dark mt-2">Salvar</button>
                        @endif
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="bo-card">
                <div class="card-header">Contrato (template.json — versão ativa)</div>
                <div class="p-0">
                    @if ($preview)
                        <pre class="small m-0 p-3" style="max-height:540px; overflow:auto; background:#fafaf7;">{{ json_encode($preview, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) }}</pre>
                    @else
                        <div class="p-3 text-muted small">Nenhuma versão ativa ou arquivo não encontrado.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
