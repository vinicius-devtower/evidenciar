@extends('layouts.backoffice')
@section('title', 'Plano de Negócio — Indicadores')

@section('content')
    <h1 class="page-title mb-3">Indicadores mensais</h1>

    @include('backoffice.dev.plano-negocio._nav')

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="bo-card p-3 mb-4">
        <h6 class="mb-3">Preencher / atualizar mês</h6>
        <p class="text-muted small">
            Clientes ativos e MRR o sistema já sabe calcular sozinho (ver Visão geral) — os
            campos abaixo são coisas que só existem se alguém registrar: quanto foi gasto em
            marketing, quantos leads foram abordados, quantas reuniões aconteceram.
        </p>
        <form method="POST" action="{{ route('dev.plano-negocio.indicadores.store') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-2">
                    <label class="form-label">Mês</label>
                    <input type="month" name="month" class="form-control"
                           value="{{ old('month', $novoIndicador->month->format('Y-m')) }}" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Clientes novos</label>
                    <input type="number" min="0" name="new_clients" class="form-control" value="{{ old('new_clients') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Gasto marketing (centavos)</label>
                    <input type="number" min="0" name="marketing_spend_cents" class="form-control" value="{{ old('marketing_spend_cents') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Leads abordados</label>
                    <input type="number" min="0" name="leads_contacted" class="form-control" value="{{ old('leads_contacted') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Reuniões feitas</label>
                    <input type="number" min="0" name="meetings_held" class="form-control" value="{{ old('meetings_held') }}">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button class="btn btn-dark w-100">Salvar</button>
                </div>
                <div class="col-12">
                    <label class="form-label">Observações</label>
                    <textarea name="notes" rows="2" class="form-control">{{ old('notes') }}</textarea>
                </div>
            </div>
        </form>
    </div>

    <div class="bo-card">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Mês</th>
                        <th>Clientes novos</th>
                        <th>Marketing</th>
                        <th>Leads</th>
                        <th>Reuniões</th>
                        <th>Obs.</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($metrics as $m)
                        <tr>
                            <td><strong>{{ $m->month->format('m/Y') }}</strong></td>
                            <td>{{ $m->new_clients ?? '—' }}</td>
                            <td>{{ $m->marketingSpendFormatted() }}</td>
                            <td>{{ $m->leads_contacted ?? '—' }}</td>
                            <td>{{ $m->meetings_held ?? '—' }}</td>
                            <td class="small text-muted">{{ \Illuminate\Support\Str::limit($m->notes, 40) }}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-outline-primary"
                                        data-bs-toggle="collapse" data-bs-target="#edit-{{ $m->id }}">Editar</button>
                            </td>
                        </tr>
                        <tr class="collapse" id="edit-{{ $m->id }}">
                            <td colspan="7">
                                <form method="POST" action="{{ route('dev.plano-negocio.indicadores.update', $m) }}" class="row g-2 p-2">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="month" value="{{ $m->month->format('Y-m-d') }}">
                                    <div class="col-md-2">
                                        <label class="form-label small">Clientes novos</label>
                                        <input type="number" min="0" name="new_clients" class="form-control form-control-sm" value="{{ $m->new_clients }}">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label small">Marketing (centavos)</label>
                                        <input type="number" min="0" name="marketing_spend_cents" class="form-control form-control-sm" value="{{ $m->marketing_spend_cents }}">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label small">Leads</label>
                                        <input type="number" min="0" name="leads_contacted" class="form-control form-control-sm" value="{{ $m->leads_contacted }}">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label small">Reuniões</label>
                                        <input type="number" min="0" name="meetings_held" class="form-control form-control-sm" value="{{ $m->meetings_held }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label small">Observações</label>
                                        <input name="notes" class="form-control form-control-sm" value="{{ $m->notes }}">
                                    </div>
                                    <div class="col-md-1 d-flex align-items-end">
                                        <button class="btn btn-sm btn-dark w-100">Salvar</button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-muted py-4">Nenhum indicador preenchido ainda.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
