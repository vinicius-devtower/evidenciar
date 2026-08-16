@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <h1>Dashboard</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            <div class="row">

                <div class="col-lg-4 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>1</h3>
                            <p>Sites</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-globe"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>1</h3>
                            <p>Templates</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-layer-group"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $user->name }}</h3>
                            <p>Usuário</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user"></i>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card mt-4">
                        <div class="card-header">
                            <h3 class="card-title">Atividades Recentes</h3>
                        </div>

                        <div class="card-body">
                            @forelse($activityLogs as $log)
                                <div class="mb-3">
                                    <strong>{{ $log->description }}</strong>

                                    <div class="text-muted small">
                                        {{ $log->created_at->format('d/m/Y H:i') }}
                                        @if ($log->user)
                                            · por {{ $log->user->name }}
                                        @endif
                                    </div>
                                </div>
                                <hr>
                            @empty
                                <p class="text-muted mb-0">
                                    Nenhuma atividade recente.
                                </p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
