@extends('layouts.backoffice')
@section('title', 'Templates & versões')

@section('content')
    <h1 class="page-title">Templates & versões</h1>
    <p class="page-sub">Lista de templates disponíveis. Os arquivos ficam no repositório; aqui você ativa versões e atribui a planos.</p>

    @foreach ($templates as $t)
        <div class="bo-card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <strong>{{ $t->name }}</strong>
                    <small class="text-muted">· <code>{{ $t->slug }}</code></small>
                </div>
                <a href="{{ route('dev.templates.show', $t) }}"
                   class="btn btn-sm btn-outline-dark">Detalhe</a>
            </div>
            <div class="table-responsive">
                <table class="table mb-0 small">
                    <thead>
                        <tr>
                            <th>Versão</th>
                            <th>Path</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($t->versions as $v)
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
                                              action="{{ route('dev.templates.versions.activate', [$t, $v]) }}"
                                              class="d-inline">
                                            @csrf
                                            <button class="btn btn-sm btn-dark">Ativar</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-muted text-center py-3">Sem versões.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-3 border-top">
                <form method="POST" action="{{ route('dev.templates.plans.sync', $t) }}">
                    @csrf
                    <div class="small mb-2 text-muted">Disponível nos planos:</div>
                    <div class="d-flex flex-wrap gap-2 mb-2">
                        @foreach ($plans as $p)
                            <label class="btn btn-sm btn-outline-dark {{ $t->plans->contains($p->id) ? 'active' : '' }}">
                                <input type="checkbox" name="plan_ids[]" value="{{ $p->id }}"
                                       class="d-none"
                                       {{ $t->plans->contains($p->id) ? 'checked' : '' }}>
                                {{ $p->name }}
                            </label>
                        @endforeach
                        @if ($plans->isEmpty())
                            <span class="text-muted small">
                                Nenhum plano cadastrado —
                                <a href="{{ route('dev.planos.create') }}">criar agora</a>.
                            </span>
                        @endif
                    </div>
                    @if ($plans->isNotEmpty())
                        <button class="btn btn-sm btn-dark">Salvar planos</button>
                    @endif
                </form>
            </div>
        </div>
    @endforeach
@endsection

@push('scripts')
<script>
    // Toggle visual dos botões-checkbox
    document.querySelectorAll('.btn-outline-dark input[type=checkbox]').forEach(cb => {
        cb.closest('label').addEventListener('click', (e) => {
            setTimeout(() => e.currentTarget.classList.toggle('active', cb.checked), 0);
        });
    });
</script>
@endpush
