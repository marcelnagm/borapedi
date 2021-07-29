@extends('layouts.app', ['title' => __('Programa de Fidelidade')])

@section('content')
<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
</div>
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-xl-12 order-xl-1">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            @if(isset($banner))
                                <h3 class="mb-0">Editando Programa de fidelidade</h3>
                            @else
                                <h3 class="mb-0">Novo Programa de fidelidade</h3>
                            @endif
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('marketing.index') }}" class="btn btn-sm btn-primary">{{ __('Back') }}</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <h6 class="heading-small text-muted mb-4">{{ __('Banner information') }}</h6>
                    @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('status') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                    <div class="pl-lg-4">
                        @if(isset($banner))
                            <form method="post" action="{{ route('fidelity_program.update', $banner->id) }}" autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            @method('put')
                        @else
                            <form method="post" action="{{ route('fidelity_program.store') }}" autocomplete="off" enctype="multipart/form-data">
                            @csrf
                        @endif
                            @include('fidelity_program.form')
                            <div>
                                @if(isset($banner))
                                    <button type="submit" class="btn btn-primary mt-4">{{ __('Update')}}</button>
                                @else
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('layouts.footers.auth')
</div>
@endsection

@section('js')
@endsection
