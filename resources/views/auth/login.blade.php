@extends('layouts.app', ['class' => 'bg'])

@section('content')
@include('layouts.headers.guest')

<div class="container mt--6 pb-5">
    <div class="row justify-content-center">
        <div class="col-7">
            Imagem Lateral
            <img src="/social/img/wpordering.svg">
        </div>
        <div class="col-5">
            @if (session('status'))
            <div class="card bg-secondary shadow border-0">
                <div class="card-body">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('status') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            </div>
            @endif


          

            <div class="card bg-secondary shadow border-0">
                <div class="card-body px-lg-5 py-lg-5">
                    
                    @if(config('app.isft')&&(strlen(config('settings.google_client_id'))>3||strlen(config('settings.facebook_client_id'))>3))
                    <div class="card-header bg-transparent pb-5">
                        <div class="btn-wrapper text-center">
                        <p>É novo por aqui? Cadastre-se</p>                            
                            <a href="{{ route('register') }}" class="btn btn-neutral btn-icon" onclick="$('#login-form').show('1000')">
                                <span class="btn-inner--icon"><i class="fas fa-user-plus"></i></span>
                                <span class="btn-inner--text">Email / Whatsappp</span>
                            </a>
                            <hr/>
                        </div>
                        <div class="text-muted text-center mt-2 mb-3"><small>Como deseja entrar?</small></div>
                        <div class="btn-wrapper text-center">
                            
                            @if (strlen(config('settings.google_client_id'))>3)
                            <a href="{{ route('google.login') }}" class="btn btn-neutral btn-icon">
                                <span class="btn-inner--icon"><img src="{{ asset('argonfront/img/google.svg') }}"></span>
                                <span class="btn-inner--text">Logar com Google</span>
                            </a>
                            @endif
                            <br>
                            <br>
                            @if (strlen(config('settings.facebook_client_id'))>3)
                            <a href="{{ route('facebook.login') }}" class="btn btn-neutral btn-icon">
                                <span class="btn-inner--icon"><img src="{{ asset('custom/img/facebook.png') }}"></span>
                                <span class="btn-inner--text">Logar com Facebook</span>
                            </a>
                            @endif
                            <br>
                            <br>
                            <a href="#" class="btn btn-neutral btn-icon" onclick="$('#login-form').show('1000')">
                                <span class="btn-inner--icon"><i styl="color:gold;"  class="fas fa-envelope"></i>></span>
                                <span class="btn-inner--text">Logar com Email / Whatsappp</span>
                            </a>
                            <br>
                            <br>
                          
                        </div>
                    </div>
                    @endif
                    <div  id="login-form"  style="display:none;">
                    <div class="nav-wrapper">
                        <ul class="nav nav-tabs nav-fill" id="res_menagment" role="tablist">

                            <li class="nav-item text-white">
                                <a class="nav-link mb-sm-3 mb-md-0 active " id="tabs-menagment-main" data-toggle="tab" href="#client" role="tab" aria-controls="tabs-menagment" aria-selected="true"><i class="ni ni-basket mr-2"></i>Cliente</a>
                            </li>
                            <li class="nav-item text-white">
                                <a class="nav-link mb-sm-3 mb-md-0 " id="tabs-menagment-main" data-toggle="tab" href="#admin" role="tab" aria-controls="tabs-menagment" aria-selected="true"><i class="ni ni ni-briefcase-24 mr-2"></i>Restaurante</a>
                            </li>                            
                        </ul>
                    </div>
                    <div class="tab-content" id="tabs">
                        <div class="tab-pane fade show active" id="client" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">

                            <form role="form" method="POST" action="{{ route('login.client') }}">
                                @csrf

                                <div class="form-group{{ $errors->has('phone') ? ' has-danger' : '' }} mb-3">
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-whatsapp "></i></span>
                                        </div>
                                        <input class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" placeholder="Whatsapp" id="phone" type="phone" name="phone" value="{{ old('phone') }}" required autofocus>
                                    </div>
                                    @if ($errors->has('phone'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                    @endif
                                </div>                                

                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input class="custom-control-input" name="remember" id="customCheckLogin" type="checkbox" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="customCheckLogin">
                                        <span class="text-muted">{{ __('Remember me') }}</span>
                                    </label>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-danger my-4">{{ __('Sign in') }}</button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade show" id="admin" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">

                            <form role="form" method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }} mb-3">
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                        </div>
                                        <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email') }}" type="email" name="email" value="{{ old('email') }}" required autofocus>
                                    </div>
                                    @if ($errors->has('email'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                        </div>
                                        <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="{{ __('Password') }}" type="password" required>
                                    </div>
                                    @if ($errors->has('password'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div> 

                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input class="custom-control-input" name="remember" id="customCheckLogin" type="checkbox" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="customCheckLogin">
                                        <span class="text-muted">{{ __('Remember me') }}</span>
                                    </label>
                                      
                        <a href="{{ route('password.request') }}" class="text-blue right">
                            {{ __('Forgot password?') }}</small>
                        </a>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-danger my-4">{{ __('Sign in') }}</button>
                                </div>                              
                            </form>
                        </div>

                    </div>
                </div>
                </div>
                <div class="row mt-3">
                    <div class="col-6">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>

    <script>

    $("#phone").mask("(00) 00000-0000");

    //$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    //    var target = $e(.target).attr("href") // activated tab
    ////        alert(target);
    //    if (target == "#client")
    //    {
    //
    //    }
    //    if (target == "#admin")
    //    {
    //
    //    }
    //});

    </script>
    @endsection
