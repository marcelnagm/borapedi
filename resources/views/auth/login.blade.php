@extends('layouts.front_nofooter_noheader', ['class' => 'bg'])

@section('content')
<style>
    
    .cart_adapt{
                width: 100vw;
    height: 47vh;
    margin-right: 200px;
        }
        
     @media only screen and (max-width:1023px) {
        .cart_adapt{
                width: 100vw;
    height: 44vh;
    margin-right: 200px;
        }
        
        .cart_adapt_left {
            /*width: 200%;*/
        }
     }
</style>

<div class="container">        
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


                     <div class="card bg-secondary shadow ">
                <div class="card-body row">
                    
                    @if(config('app.isft')&&(strlen(config('settings.google_client_id'))>3||strlen(config('settings.facebook_client_id'))>3))
                       
                        
                        <div class="col text-center  left">
                            <img src="/social/img/wpordering.svg" class="cart_adapt rounded" style="    margin-left: 3em;" alt="Responsive image" width="80%">
                        </div>
                        <div class="col text-center cart_adapt_left left">
                            <div class="text-muted text-center ">Como deseja entrar?</div>
                        <div class="btn-wrapper ">
                            </hr>    
                            @if (strlen(config('settings.google_client_id'))>3)
                            <a style="width:100%;margin-bottom:10px;" href="{{ route('google.login') }}" class="btn btn-neutral btn-icon">
                                <span class="btn-inner--icon"><img class="fas" src="{{ asset('argonfront/img/google.svg') }}"></span>
                                <span class="btn-inner--text"> Logar com Google</span>
                            </a>
                            @endif
                            <br>
                            @if (strlen(config('settings.facebook_client_id'))>3)
                            <a style="width:100%" href="{{ route('facebook.login') }}" class="btn btn-neutral btn-icon btn-lg">                                
                                <span class="btn-inner--icon"><img class="fas" src="{{ asset('custom/img/facebook.png') }}"></span>
                                <span class="btn-inner--text">Logar com Facebook</span>
                            </a>                           
                            <br>
                            @endif                          <br>
                            <a style="width:100%" href="#" class="btn btn-neutral btn-icon" onclick="$('#login-form').show('1000')">
                                <span  class="btn-inner--icon"><i styl="color:gold;"  class="fas fa-envelope"></i>></span>
                                <span class="btn-inner--text">Logar com Email / Whatsappp</span>
                            </a>
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
                                      
                        <a href="{{ route('password.request') }}" class="text-blue right                         <a href="{{ route('password.request') }}" class="text-blue right custom-control-label ">
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
