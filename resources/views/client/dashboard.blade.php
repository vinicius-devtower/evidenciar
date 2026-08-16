@extends('layouts.app')
@section('content')
<div class="container py-4">
    <h2 class="mb-4">
        Bem-vindo, {{ $user->name }} 👋
    </h2>
    <p class="text-muted mb-4">
        Seu site já foi criado. Agora é só editar o conteúdo e solicitar a publicação.
    </p>
    @foreach($sites as $site)
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ $site->name }}</h5>
                <p class="mb-2">
                    Status:
                    <span class="badge badge-secondary">
                        {{ ucfirst($site->status) }}
                    </span>
                </p>
                <a href="{{ route('app.sites.edit', $site) }}" class="btn btn-success">
                    Editar meu site
                </a>
                <a href="{{ route('app.sites.preview', $site) }}" class="btn btn-outline-secondary ml-2">
                    Preview
                </a>
            </div>
        </div>
    @endforeach
</div>
@endsection
