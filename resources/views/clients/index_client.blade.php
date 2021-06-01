@extends('layouts.app', ['title' => __('Clients')])

@section('content')
<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
</div>

<div class="container-fluid mt--7">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <h3 class="mb-0">{{ __('Clients') }}</h3>
                        </div>
                    </div>
                </div>

                @include('clients.filter')
                <div class="col-12">
                    @include('partials.flash')
                </div>
                
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Nome</th>
                                <th scope="col">Email</th>
                                <th scope="col">Data de Registro</th>
                                @if(config('settings.enable_birth_date_on_register'))
                                <th scope="col">{{ __('Birth Date') }}</th>
                                @endif
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($clients as $client)
                            <tr>
                                <td>{{ $client->name }}</td>
                                <td>
                                    <a href="mailto:{{ $client->email }}">{{ $client->email }}</a>
                                </td>
                                <td>{{ $client->created_at->format(config('settings.datetime_display_format')) }}</td>
                                @if(config('settings.enable_birth_date_on_register'))
                                <th scope="col">{{ $client->birth_date }}</th>
                                @endif                              
                                @include('clients.actions')
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer py-4">
                    <nav class="d-flex justify-content-end" aria-label="...">
                    </nav>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.footers.auth')
</div>
@endsection
