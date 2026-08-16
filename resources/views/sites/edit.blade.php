@extends('layouts.admin')
@section('title', 'Editar Site')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <h1>Editor do Site</h1>
            <p class="text-muted">{{ $site->name }}</p>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <form method="POST" action="{{ route('app.sites.update', $site) }}">
                @csrf
                @method('POST')
                @foreach ($templateConfig['sections'] as $section)
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title">{{ $section['label'] }}</h3>
                        </div>
                        <div class="card-body">
                            @foreach ($section['fields'] as $field)
                                @php
                                    $fieldName = "content[{$section['id']}][{$field['key']}]";
                                    $fieldValue = $content[$section['id']][$field['key']] ?? '';
                                @endphp
                                <div class="form-group">
                                    <label>{{ $field['label'] }}</label>
                                    @if ($field['type'] === 'text')
                                        <input type="text" name="{{ $fieldName }}" class="form-control"
                                            value="{{ $fieldValue }}">
                                    @elseif($field['type'] === 'textarea')
                                        <textarea name="{{ $fieldName }}" class="form-control" rows="4">{{ $fieldValue }}</textarea>
                                    @elseif($field['type'] === 'url')
                                        <input type="url" name="{{ $fieldName }}" class="form-control"
                                            value="{{ $fieldValue }}">
                                    @elseif($field['type'] === 'boolean')
                                        <div class="form-check">
                                            <input type="checkbox" name="{{ $fieldName }}" class="form-check-input"
                                                value="1" {{ $fieldValue ? 'checked' : '' }}>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
                <button type="submit" class="btn btn-primary">
                    Salvar Conteúdo
                </button>
            </form>
            {{-- HISTÓRICO --}}
            <div class="card mt-4">
                <div class="card-header">
                    <h3 class="card-title">Histórico</h3>
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
                        <p class="text-muted">
                            Nenhuma atividade registrada ainda.
                        </p>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
@endsection
