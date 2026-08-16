@extends('layouts.backoffice')
@section('title', 'Dev — Visão geral')

@section('content')
    <h1 class="page-title">Visão geral — Desenvolvimento</h1>
    <p class="page-sub">Catálogo de templates, versões e planos.</p>

    <div class="row g-3 mb-4">
        @foreach ([
            ['label'=>'Templates',      'value'=>$stats['templates'],      'icon'=>'bi-layers',       'tone'=>''],
            ['label'=>'Versões ativas', 'value'=>$stats['versoes_ativas'], 'icon'=>'bi-git',          'tone'=>'success'],
            ['label'=>'Sites no ar',    'value'=>$stats['sites'],          'icon'=>'bi-globe',        'tone'=>'info'],
            ['label'=>'Planos',         'value'=>$stats['planos'],         'icon'=>'bi-tags',         'tone'=>''],
        ] as $card)
            <div class="col-6 col-md-3">
                <div class="bo-stat {{ $card['tone'] ? 'bo-stat--'.$card['tone'] : '' }}">
                    <div class="bo-stat__icon"><i class="bi {{ $card['icon'] }}"></i></div>
                    <div class="bo-stat__body">
                        <div class="bo-stat__label">{{ $card['label'] }}</div>
                        <div class="bo-stat__value">{{ $card['value'] }}</div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="bo-card">
        <div class="card-header d-flex justify-content-between">
            <span>Templates & versões</span>
            <a href="{{ route('dev.templates.index') }}" class="btn btn-sm btn-outline-dark">Abrir catálogo</a>
        </div>
        <div class="table-responsive">
            <table class="table mb-0 small">
                <thead>
                    <tr>
                        <th>Template</th>
                        <th>Slug</th>
                        <th>Versão ativa</th>
                        <th>Total de versões</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($templates as $t)
                        @php $active = $t->versions->firstWhere('is_active', true); @endphp
                        <tr>
                            <td>{{ $t->name }}</td>
                            <td><code>{{ $t->slug }}</code></td>
                            <td>{{ $active?->version ?? '—' }}</td>
                            <td>{{ $t->versions->count() }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center text-muted py-3">Sem templates.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
