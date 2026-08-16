@extends('layouts.admin')
@section('title', 'Templates')
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <h1>Templates</h1>
    </div>
</section>
<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Template</th>
                            <th>Versões</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($templates as $template)
                            <tr>
                                <td>{{ $template->name }}</td>
                                <td>
                                    @foreach($template->versions as $version)
                                        <span class="badge badge-info">
                                            {{ $version->version }}
                                        </span>
                                    @endforeach
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection
