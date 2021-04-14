@extends('layouts.front', ['title' => __('Orders')])

@section('content')
<div class="header bg-primary pb-6 pt-5 pt-md-8">
    Faça o login para continuar
</div>
<div class="container-fluid mt--6">
  
    <div class="row">
        <div class="col-sm">
            <div class="col card-header border-0">
                <h3 class="mb-0">Registrar</h3>
            </div>
            <form action="{{ route('client-register') }}" class="d-flex flex-column mb-5 mb-lg-0" method="POST">
                 @csrf
                <input class="form-control" type="text" name="name" placeholder="{{ __('whatsapp.modal_input_name')}}" required>
                <input class="form-control my-3" type="email" name="email" placeholder="{{ __('whatsapp.modal_input_email')}}" required>
                <input class="form-control my-1" type="text" name="phone" placeholder="{{ __('whatsapp.modal_input_phone')}}" required>
                <button disabled class="btn btn-success my-3" id="submitRegister1" type="submit">{{ __('whatsapp.join_now')}}</button>

                <div class="form-check"><input type="checkbox" name="termsCheckBox" id="termsCheckBox1" class="form-check-input" onclick="habilita(1)"> 
                    <label for="terms" class="form-check-label">
                        &nbsp;&nbsp;{{__('whatsapp.i_agree_to')}}
                        <a href="{{config('settings.link_to_ts')}}" target="_blank" style="text-decoration: underline;">{{__('whatsapp.terms_of_service')}}</a> {{__('whatsapp.and')}}
                        <a href="{{config('settings.link_to_pr')}}" target="_blank" style="text-decoration: underline;">{{__('whatsapp.privacy_policy')}}</a>.
                    </label>
                </div>
            </form>
        </div>
        <div class="col-sm">
            <div class="col card-header border-0">
                <h3 class="mb-0">Login</h3>
            </div>
            <form action="{{ route('client-login') }}" class="d-flex flex-column mb-5 mb-lg-0" method="POST">                
                 @csrf
                <input class="form-control my-3" type="email" name="email" placeholder="{{ __('whatsapp.modal_input_email')}}" required>
                <input class="form-control my-1" type="text" name="phone" placeholder="{{ __('whatsapp.modal_input_phone')}}" required>
                <button class="btn btn-success my-3" id="submitRegister2" type="submit">{{ __('whatsapp.join_now')}}</button>

            </form>
        </div>
    </div>
</div>
 <script>
    function habilita(id ) {        
        $('#submitRegister'+id).prop("disabled", !$("#termsCheckBox"+id).prop("checked")); 
    }
 </script>
@endsection

