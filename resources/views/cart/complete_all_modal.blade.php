
<style>

    .hidden_field{
        display:none !important;
    }
</style>
<div class="modal fade" id="modal-order-complete" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden_field="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-large" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-notification">Cadastro</h3>                
            </div>
            <div class="modal-body p-0">
                <div class="card bg-secondary shadow border-0">
                    <div class="card-body px-lg-5 py-lg-5" id="new_address_checkout_body">
                        <div class="tab-content" id="tabs">
                            <div class="tab-pane fade show active" id="passo1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                                <p class="text-justify">
                                    Percebemos que é o seu primeiro pedido, para dar continuidade  preencha o restante dos dados
                                    e já vamos finalizar o seu pedido.
                                </p>
                                <div class="row">
                                    <div class="col-12">
                                        @include('partials.fields',['fields'=>[
                                        ['ftype'=>'input','name'=>"Nome",'id'=>"nome",'placeholder'=>"Coloque aqui seu email",'required'=>true]
                                        ]])    
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">                           
                                        @include('partials.fields',['fields'=>[
                                        ['ftype'=>'input','name'=>"Email",'id'=>"email",'placeholder'=>"Coloque aqui seu email",'required'=>false]
                                        ]])                         
                                    </div>
                                </div>                                       
                                <div class="row">
                                    <div class="col-12">                           

                                        <button class="btn btn-danger right" href="#" onclick="passo2()" style="width: 100%;">Proximo</button>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade show" id="passo2" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">

                                <div class="card-content border-top">

                                    <div class="row">
                                        <div class="col-12">
                                            @include('partials.fields',['fields'=>[
                                            ['ftype'=>'input','name'=>"Apelido",'id'=>"nick2",'placeholder'=>"Casa,Trabalho, Casa do Amigo",'required'=>true]
                                            ]])    
                                        </div>
                                    </div>
                                    <div class="row" style="margin-bottom:10px;">
                                <div class="col-12">
                                    <div id="form-group-cep" class="form-group  ">
                                        <label class="form-control-label cep-label" for="cep" >Cep: <a  alt="Não sei Meu Cef"  target="_blank"  href="https://buscacepinter.correios.com.br/app/endereco/index.php?t" style="font-style: italic;" >Não sei <i class="fas fa-question-circle"></i></a></label>
                                        </br>
                                        </br>
                                        <input  type="text" name="Cep" id="cep2" class="form-control form-control cep-form  " placeholder="Coloque seu CEP aqui ..." required="" autofocus="" style="width:95% !important;"> 
                                        <button type="button" style="float:left; width: 5%;height:40px;" onclick="getAdd2()">
                                        <span class="input-group-text cep-label" style="float:left; width: 10%;height:40px"><i id="search_location" class="fa fa-map-pin" data-toggle="tooltip" data-placement="top" title="" data-original-title="Pegar minha localização"></i></span>
                                        </button>   
                                    </div> 
                                        
                                    </div>                                                                 
                            </div>
                                    <p id='result_cep'>
                                    </p>
                            

                                    <div class="row hidden_field" >
                                        <div class="col-12">                           
                                            @include('partials.fields',['fields'=>[
                                            ['ftype'=>'input','name'=>"Logradouro",'id'=>"adds2",'placeholder'=>"",'required'=>true,'readonly' => true]
                                            ]])                         
                                        </div>
                                    </div>
                                    <div class="row hidden_field">
                                        <div class="col-12">
                                            @include('partials.fields',['fields'=>[
                                            ['ftype'=>'input','name'=>"Bairro",'id'=>"address_neigh2",'placeholder'=>"",'required'=>true,'readonly' => true]
                                            ]])
                                        </div>
                                    </div>

                                    <div class="row hidden_field">
                                        <div class="col-12">
                                            @include('partials.fields',['fields'=>[
                                            ['ftype'=>'input','name'=>"Cidade/Estado",'id'=>"address_city2",'placeholder'=>"",'required'=>true,'readonly' => true]
                                            ]])
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            @include('partials.fields',['fields'=>[            
                                            ['ftype'=>'input','name'=>"Número",'id'=>"numbero2",'placeholder'=>"Numero",'required'=>true],
                                            ]])
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            @include('partials.fields',['fields'=>[            
                                            ['ftype'=>'input','name'=>"Complemento",'id'=>"complement2",'placeholder'=>"Apartamento, Casa, e etc..'",'required'=>true]
                                            ]])   </div>
                                    </div>
                                    <input type="hidden"  name="phone_send"  id="phone_send" value="" > 
                                    <div class="row">
                                        <div class="col-12"> 
                                            <button class="btn btn-danger left" value="Proximo" onclick="passo1()" style="width: 45%">Voltar</button>                                 
                                            <button class="btn btn-danger left" value="Proximo" onclick="passo3()" style="width: 45%">Proximo</button>
                                        </div>
                                    </div>


                                </div>
                            </div>                                 
                            <div class="tab-pane fade show " id="passo3" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">                                
                                <div class="row">
                                    <div class="col-12">
                                        <p class="text-justify">
                                            Confira os seus dados
                                        </p>
                                    </div>
                                    <div class="col-12">
                                        <p class="text-justify">
                                        <div id="result-nome">

                                        </div>
                                        <div id="result-email">

                                        </div>
                                        <div id="result-endereco">

                                        </div>
                                        </p>
                                    </div>
                                </div>                                                                                                               
                                <a class="btn btn-danger left" href="#" onclick="passo2()" style="width: 45%;">Voltar</a>
                                <button type="button" id="submitNewAddress2" class="btn btn-success left" style="width: 50%">Concluir</button>    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>


<script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
crossorigin="anonymous"></script>
<script>

                                    function getAdd2() {
                                        if (navigator.geolocation) {
                                            navigator.geolocation.getCurrentPosition(function (position) {
                                                var pos = {lat: position.coords.latitude, lng: position.coords.longitude};
                                                $.ajaxSetup({
                                                    headers: {
                                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                    }
                                                });
                                                $.ajax({
                                                    type: 'POST',
                                                    url: '/search/location',
                                                    dataType: 'json',
                                                    data: {
                                                        lat: position.coords.latitude,
                                                        lng: position.coords.longitude
                                                    },
                                                    success: function (response) {
                                                        if (response.status) {
                                                            console.log(response.data);
                                                            $("#txtlocation2").val(response.data.formatted_address);
                                                            $("#adds2").val(response.data.address_components[1]['long_name']);
                                                            $("#address_neigh2").val(response.data.address_components[2]['long_name']);
                                                            $("#address_city2").val(response.data.address_components[3]['long_name'] + ' - ' + response.data.address_components[4]['long_name']);
                                                            $("#numbero2").val(response.data.address_components[0]['long_name']);
                                                            $("#cep2").val(response.data.address_components[6]['long_name']);
                                                            $("#submitNewAddress2").show();
                                                            end = $("#adds2").val() +' -' + $("#address_neigh2").val() + ' ' + $("#address_city2").val() + ' / ' + $("#cep2").val();
                                                            $("#result_cep").text('');
                                                            $("#result_cep").text(end);
                                                            notify("\nEndereço detectado", 'success');
                                                        }
                                                    }, error: function (response) {
                                                        notify("\nErro desconhecido", 'error');
                                                    }
                                                });
                                            });
                                        } else {
//                                                 Browser doesn't support Geolocation
//                                                handleLocationError(false, infoWindow, map.getCenter());
                                        }
                                    }

                                    function passo2() {
                                        var nome = $("#nome").val();
                                        var email = $("#email").val();
                                        if (nome.length > 1) {
                                            var letters = /^[A-Za-z]+$/;
                                            if (nome.match(letters)) {
                                                if (email.length > 0) {
                                                    const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                                                    if (re.test(String(email).toLowerCase())) {
                                                        $('#passo1').hide();
                                                        $('#passo3').hide();
                                                        $('#passo2').show();
                                                    } else {
                                                        notify("\nPreencha o campo email corretamente", 'error');
                                                    }
                                                } else {
                                                    $('#passo1').hide();
                                                    $('#passo3').hide();
                                                    $('#passo2').show();
                                                    }
                                                
                                            } else {
                                                notify("\nPreencha o campo nome somente com letras", 'error');
                                            }

                                        } else {
                                            notify("\nPreencha o campo nome somente com letras", 'error');
                                        }
                                    }

                                    function passo3() {
                                        var nick = $("#nick2").val();
                                        var nome = $("#nome").val();
                                        var email = $("#email").val();
                                        var end = $("#adds2").val() + ' ' + $("#numbero2").val() + ' -' + $("#address_neigh2").val() + ' ' + $("#address_city2").val() + ' / ' + $("#cep2").val();
                                        var address_number = $("#numbero2").val();

                                        var doSubmit = true;
                                        var message = "";
                                        if (address_number.length < 1) {
                                            doSubmit = false;
                                            message += "\nPreencha o campo numero";
                                        }
                                        if (nick.length < 1) {
                                            doSubmit = false;
                                            message += "\nPreencha o campo apelido para o endereco";
                                        }
                                        notify(message, 'error');
                                        if (doSubmit) {
                                            $('#passo1').hide();
                                            $('#passo2').hide();
                                            $('#passo3').show();
                                            $("#result-nome").html("<b>Nome:</b> \n" + nome);
                                            $("#result-email").html(" \n<b>Email:</b>  " + email);
                                            $("#result-endereco").html("<b>Endereço:</b> \n" + end);
                                            $("#submitNewAddress2").show();
                                        }

                                    }

                                    function passo1() {
                                        $('#passo1').show();
                                        $('#passo2').hide();
                                        $('#passo3').hide();
                                        $("#submitNewAddress2").hide();
                                    }

                                    $(document).ready(function ($) {

                                        $("#submitNewAddress2").hide();

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
                                                            $("#submitNewAddress").show();
                                                            notify("\n Cep Encontrado", 'success');
                                                            end = $("#adds2").val() +' -' + $("#address_neigh2").val() + ' ' + $("#address_city2").val() + ' / ' + $("#cep2").val();
                                                            $("#result_cep").text(end);
                                                            
                                                        } //end if.
                                                        else {
//CEP pesquisado não foi encontrado.                  
                                                            notify("\nCEP não encontrado.", 'error');
                                                        }
                                                    });
                                                } //end if.
                                                else {
//cep é inválido.                      
                                                    notify("\nFormato de CEP inválido", 'error');
                                                }
                                            } //end if.
                                            else {
//cep sem valor, limpa formulário.

                                            }
                                        });
                                    }
                                    );


</script>
