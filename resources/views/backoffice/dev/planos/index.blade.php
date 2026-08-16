@extends('layouts.backoffice')
@section('title', 'Planos')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="page-title mb-1">Planos</h1>
            <p class="page-sub mb-0">Catálogo de planos e templates associados.</p>
        </div>
        <a href="{{ route('dev.planos.create') }}" class="btn btn-dark">Novo plano</a>
    </div>

    <div class="bo-card">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Slug</th>
                        <th>Ciclo</th>
                        <th>Preço mensal</th>
                        <th>Preço anual (à vista)</th>
                        <th>Templates</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($plans as $p)
                        <tr>
                            <td><strong>{{ $p->name }}</strong></td>
                            <td><code>{{ $p->slug }}</code></td>
                            <td>{{ $p->billing_cycle }}</td>
                            <td>{{ $p->priceFormatted() }}</td>
                            <td>
                                {{ $p->annualPriceFormatted() }}
                                <span class="text-muted small">({{ $p->annualDiscountPercent() }}% OFF{{ empty($p->annual_price_cents) ? ', auto' : '' }})</span>
                            </td>
                            <td>
                                @foreach ($p->templates as $t)
                                    <span class="badge bg-light text-dark border">{{ $t->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                @if ($p->is_active)
                                    <span class="badge bg-success">Ativo</span>
                                @else
                                    <span class="badge bg-secondary">Inativo</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('dev.planos.edit', $p) }}"
                                   class="btn btn-sm btn-outline-primary">Editar</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center text-muted py-4">Nenhum plano cadastrado.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
