@extends('layouts.admin')
@section('title', 'Sites')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <h1>Sites</h1>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    @if ($sites->isEmpty())
                        <p>Nenhum site cadastrado.</p>
                    @else
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Situação</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sites as $site)
                                    <tr>
                                        <td>{{ $site->name }}</td>
                                        <td>
                                            @if ($site->hasOpenPublicationRequest())
                                                <span class="badge badge-warning">
                                                    <i class="fas fa-clock"></i> Publicação solicitada
                                                </span>
                                            @elseif($site->status === 'published')
                                                <span class="badge badge-success">Publicado</span>
                                            @else
                                                <span class="badge badge-secondary">Rascunho</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{-- Preview sempre disponível --}}
                                            <a href="{{ route('app.sites.preview', $site) }}" class="btn btn-sm btn-secondary">
                                                Preview
                                            </a>
                                            <a href="{{ route('app.sites.edit', $site) }}" class="btn btn-sm btn-warning">
                                                Editar
                                            </a>
                                            {{-- Acesso público somente se publicado --}}
                                            @if ($site->status === 'published')
                                                <a href="{{ route('app.sites.public.show', $site->slug) }}"
                                                    class="btn btn-sm btn-success" target="_blank">
                                                    Ver site
                                                </a>
                                            @endif
                                            @if ($site->status === 'draft' && !$site->hasOpenPublicationRequest())
                                                <form method="POST"
                                                    action="{{ route('app.sites.request-publication', $site) }}"
                                                    class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-success">
                                                        Solicitar Publicação
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
