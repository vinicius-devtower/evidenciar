@extends('layouts.admin')
@section('title', $site->name)
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <h1>{{ $site->name }}</h1>
    </div>
</section>
<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <p><strong>Status:</strong> {{ $site->status }}</p>
                <h5>Conteúdo (JSON)</h5>
                <pre class="bg-light p-3">
{{ json_encode($site->content, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}
                </pre>
            </div>
        </div>
    </div>
</section>
@endsection
