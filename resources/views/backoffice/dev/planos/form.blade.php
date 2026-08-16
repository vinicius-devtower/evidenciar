@extends('layouts.backoffice')
@section('title', $plan->exists ? 'Editar plano' : 'Novo plano')

@section('content')
    @php
        $route   = $plan->exists ? route('dev.planos.update', $plan) : route('dev.planos.store');
        $method  = $plan->exists ? 'PUT' : 'POST';
    @endphp

    <a href="{{ route('dev.planos.index') }}" class="text-muted small text-decoration-none">← voltar</a>
    <h1 class="page-title mb-3">{{ $plan->exists ? 'Editar plano' : 'Novo plano' }}</h1>

    <form method="POST" action="{{ $route }}">
        @csrf
        @if ($method === 'PUT') @method('PUT') @endif

        <div class="bo-card p-3 mb-3">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nome</label>
                    <input name="name" value="{{ old('name', $plan->name) }}"
                           class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Slug</label>
                    <input name="slug" value="{{ old('slug', $plan->slug) }}"
                           class="form-control" required>
                </div>
                <div class="col-12">
                    <label class="form-label">Descrição</label>
                    <textarea name="description" rows="2"
                              class="form-control">{{ old('description', $plan->description) }}</textarea>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Preço (centavos)</label>
                    <input name="price_cents" type="number" min="0"
                           value="{{ old('price_cents', $plan->price_cents) }}"
                           class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Ciclo</label>
                    <select name="billing_cycle" class="form-select">
                        <option value="monthly" {{ old('billing_cycle', $plan->billing_cycle) === 'monthly' ? 'selected' : '' }}>Mensal</option>
                        <option value="yearly"  {{ old('billing_cycle', $plan->billing_cycle) === 'yearly'  ? 'selected' : '' }}>Anual</option>
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <div class="form-check">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1" id="isActive"
                               class="form-check-input"
                               {{ old('is_active', $plan->is_active) ? 'checked' : '' }}>
                        <label for="isActive" class="form-check-label">Plano ativo</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="bo-card p-3 mb-3">
            <h6 class="mb-3">Templates disponíveis neste plano</h6>
            @forelse ($templates as $t)
                <div class="form-check">
                    <input type="checkbox" name="template_ids[]" value="{{ $t->id }}"
                           id="t-{{ $t->id }}" class="form-check-input"
                           {{ $plan->templates->contains($t->id) ? 'checked' : '' }}>
                    <label for="t-{{ $t->id }}" class="form-check-label">
                        {{ $t->name }} <small class="text-muted">· <code>{{ $t->slug }}</code></small>
                    </label>
                </div>
            @empty
                <span class="text-muted small">Nenhum template cadastrado.</span>
            @endforelse
        </div>

        <button class="btn btn-dark">{{ $plan->exists ? 'Atualizar plano' : 'Criar plano' }}</button>
    </form>
@endsection
