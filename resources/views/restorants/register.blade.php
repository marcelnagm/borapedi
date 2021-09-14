@extends('layouts.front', ['title' => __('User Profile')])
@if (strlen(config('settings.recaptcha_site_key'))>2)
@section('head')
{!! htmlScriptTagJsApi([]) !!}
@endsection
@endif

@section('content')
@include('users.partials.header', [
'title' => "",
])

<style>

    .hidden_field{
        display:none !important;
    }
    
    input{
      width:95% !important;
        float:left;
    }
    .check_field i{
        display: none;
        margin-left: 10px;
    }
    .form-control-label-cep{
        width:10% !important;
    }

</style>

<div class="container-fluid mt--7">
    <div class="row">

    </div>
    <div class="col-xl-8 offset-xl-2">
        <div class="card bg-secondary shadow">
            <div class="card-header bg-white border-0">
                <div class="row align-items-center">
                    <h3 class="col-12 mb-0">{{ __('Register your restaurant') }}</h3>
                </div>
            </div>
            <div class="card-body">
                <form  id="registerform" method="post" action="{{ route('newrestaurant.store') }}" autocomplete="off">
                    @csrf

                    <h6 class="heading-small text-muted mb-4">{{ __('Restaurant information') }}</h6>

                    @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('status') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                    <div class="pl-lg-4">
                        <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="name">{{ __('Restaurant Name') }}</label>
                            <div class="check_field">                            
                            <input type="text" name="name" id="name" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Restaurant Name here') }} ..." value="{{ isset($_GET["name"])?$_GET['name']:""}}" required autofocus onkeyup="checkField(this);">
                            <i id="name_loading" class="fas fa-spinner fa-spin"></i>
                            <i id="name_error" style="color:red;" class="fas fa-times-circle" data-toggle="tooltip" data-placement="top" title="Não disponivel"></i>
                            <i id="name_ok" style="color:green;" class="fas fa-check" data-toggle="tooltip" data-placement="top" title="Disponivel"></i>
                            </div>
                            @if ($errors->has('name'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="pl-lg-4">
                        <div class="form-group{{ $errors->has('subdomain') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="name">Subdomínio</label>
                            <div class="check_field">
                            <input type="text" name="name" id="subdomain" class="form-control form-control-alternative{{ $errors->has('subdomain') ? ' is-invalid' : '' }}" placeholder="{{ __('Restaurant subdomain here') }} ..." value="{{ isset($_GET["subdomain"])?$_GET['subdomain']:""}}" required autofocus onkeyup="checkField(this);">
                            <i id="subdomain_loading" class="fas fa-spinner fa-spin"></i>
                            <i id="subdomain_error" style="color:red;" class="fas fa-times-circle" data-toggle="tooltip" data-placement="top" title="Não disponivel"></i>
                            <i id="subdomain_ok" style="color:green;" class="fas fa-check" data-toggle="tooltip" data-placement="top" title="Disponivel"></i>
                            </div>
                            @if ($errors->has('subdomain'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('subdomain') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <hr class="my-4" />
                    <h6 class="heading-small text-muted mb-4">{{ __('Owner information') }}</h6>
                    <div class="pl-lg-4">
                        <div class="form-group{{ $errors->has('name_owner') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="name_owner">{{ __('Owner Name') }}</label>
                            <input type="text" name="name_owner" id="name_owner" class="form-control form-control-alternative{{ $errors->has('name_owner') ? ' is-invalid' : '' }}" placeholder="{{ __('Owner Name here') }} ..." value="{{ isset($_GET["name"])?$_GET['name']:""}}" required autofocus>

                            @if ($errors->has('name_owner'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('name_owner') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('email_owner') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="email_owner">{{ __('Owner Email') }}</label>
                            <div class="check_field">                            
                            <input type="email" name="email_owner" id="email_owner" class="form-control form-control-alternative{{ $errors->has('email_owner') ? ' is-invalid' : '' }}" placeholder="{{ __('Owner Email here') }} ..." value="{{ isset($_GET["email"])?$_GET['email']:""}}" required autofocus onkeyup="checkField(this);">
                            <i id="email_owner_loading" class="fas fa-spinner fa-spin"></i>                            
                            <i id="email_owner_error" style="color:red;" class="fas fa-times-circle" data-toggle="tooltip" data-placement="top" title="Não disponivel"></i>
                            <i id="email_owner_ok" style="color:green;" class="fas fa-check" data-toggle="tooltip" data-placement="top" title="Disponivel"></i>
                            </div>
                            @if ($errors->has('email_owner'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email_owner') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('phone_owner') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="phone_owner">{{ __('Owner Phone') }}</label>
                            <div class="check_field">                            
                            <input type="text" name="phone_owner" id="phone_owner" class="form-control form-control-alternative{{ $errors->has('phone_owner') ? ' is-invalid' : '' }}" placeholder="{{ __('Owner Phone here') }} ..." value="{{ isset($_GET["phone"])?$_GET['phone']:""}}" required autofocus onkeyup="checkField(this);">
                              <i id="phone_owner_loading" class="fas fa-spinner fa-spin"></i>
                            <i id="phone_owner_error" style="color:red;" class="fas fa-times-circle" data-toggle="tooltip" data-placement="top" title="Não disponivel"></i>
                            <i id="phone_owner_ok" style="color:green;" class="fas fa-check" data-toggle="tooltip" data-placement="top" title="Disponivel"></i>
                            </div>
                            @if ($errors->has('phone_owner'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('phone_owner') }}</strong>
                            </span>
                            @endif
                        </div>
                        </div>
                        <hr class="my-4" />
                        <h6 class="heading-small text-muted mb-4">Endereço do Estabelicmento</h6>
                        <div class="pl-lg-4">
                                    @include('partials.fields',['fields'=>[
                                    ['ftype'=>'input','aditionalClassLabel' =>'form-control-label-cep','name'=>"Cep",'id'=>"cep2",'placeholder'=>"Cep",'required'=>true]
                                    ]])                                          
                                
                            <p id='result_cep'>
                            </p>
                            <div class="hidden_field" >
                                    @include('partials.fields',['fields'=>[
                                    ['ftype'=>'input','name'=>"Logradouro",'id'=>"adds2",'placeholder'=>"",'required'=>true,'readonly' => true]
                                    ]])                         
                                    @include('partials.fields',['fields'=>[
                                    ['ftype'=>'input','name'=>"Bairro",'id'=>"address_neigh2",'placeholder'=>"",'required'=>true,'readonly' => true]
                                    ]])
                                    @include('partials.fields',['fields'=>[
                                    ['ftype'=>'input','name'=>"Cidade/Estado",'id'=>"address_city2",'placeholder'=>"",'required'=>true,'readonly' => true]
                                    ]])
                            </div>
                                    @include('partials.fields',['fields'=>[            
                                    ['ftype'=>'input','name'=>"Número",'id'=>"numbero2",'placeholder'=>"Numero",'required'=>true],
                                    ]])
                                    @include('partials.fields',['fields'=>[            
                                    ['ftype'=>'input','name'=>"Complemento",'id'=>"complement2",'placeholder'=>"Apartamento, Casa, e etc..'",'required'=>false]
                                    ]])   </div>
                        <div class="text-center">
                            @if (strlen(config('settings.recaptcha_site_key'))>2)
                            @if ($errors->has('g-recaptcha-response'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                            </span>
                            @endif

                            {!! htmlFormButton(__('Save'), ['id'=>'thesubmitbtn','class' => 'btn btn-success mt-4']) !!}
                            @else
                            <button type="submit" id="thesubmitbtn" class="btn btn-success mt-4">Cadastrar</button>
                            @endif


                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>

<script>
$("#phone_owner").mask("(00) 00000-0000");
$("#cep2").mask("00000-000");
$(function () {
  $('[data-toggle="tooltip"]').tooltip();
});

function checkField(field) {
    var id =field.getAttribute('id');
        console.log($('#'+id).val());
        
        $('#'+id+'_ok').hide();
        $('#'+id+'_error').hide();
        var json = '{"'+id+'" :"'+$('#'+id).val()+'"}';
        $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
         $.ajax({
        type: 'POST',
        url: '{{route('restorant.validate')}}',
            dataType: 'json',
        data: json,
        success: function (response) {
//                alert('sucess');
            $('#'+id+'_loading').hide();
            $('#'+id+'_ok').hide();
            $('#'+id+'_error').hide();
        
            console.log(response);
            if (response.status===true){
               $('#'+id+'_ok').show();
               $('#'+id+'_ok').attr("data-original-title",response.msg);
            }else{                 
               $('#'+id+'_error').show();
//               $('#'+id+'_error').attr("title","");
               $('#'+id+'_error').attr("data-original-title",response.msg);
            }
                
        }, error: function (response) {
            //alert(response.responseJSON.errMsg);
            $('#'+id+'_loading').hide();
           
               $('#'+id+'_error').show();
        }
    });
    }


$(document).ready(function ($) {
    //Quando o campo cep perde o foco.
    
    $("#cep2").blur(function () {
//Nova variável "cep" somente com dígitos.
        var cep = $(this).val().replace(/\D/g, '');
        cep = cep.replace('-', '');
        $("#numbero2").val('');
        //Verifica se campo cep possui valor informado.
        if (cep != "") {

//Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;
            //Valida o formato do CEP.
            if (validacep.test(cep)) {

//Preenche os campos com "..." enquanto consulta webservice.

//Consulta o webservice viacep.com.br/
                $.getJSON("https://viacep.com.br/ws/" + cep + "/json/?callback=?", function (dados) {

                    if (!("erro" in dados)) {
//Atualiza os campos com os valores da consulta.
                        console.log(dados.logradouro);
                        $("#adds2").val(dados.logradouro);
                        $("#address_neigh2").val(dados.bairro);
                        $("#address_city2").val(dados.localidade + ' - ' + dados.uf);
                        end = $("#adds2").val() + ' -' + $("#address_neigh2").val() + ' ' + $("#address_city2").val() + ' / ' + $("#cep2").val();
                        $("#result_cep").text('');
                        $("#result_cep").text(end);

                    } //end if.
                    else {
//CEP pesquisado não foi encontrado.                              
                        alert("CEP não encontrado.");
                    }
                });
            } //end if.
            else {
//cep é inválido.                      
                alert("Formato de CEP inválido.");
            }
        } //end if.
        else {
//cep sem valor, limpa formulário.

        }
    });
});

</script>
@endsection
@section('js')
@if (isset($_GET['name'])&&$errors->isEmpty())
<script>
    "use strict";
    document.getElementById("thesubmitbtn").click();
</script>
@endif
@endsection
