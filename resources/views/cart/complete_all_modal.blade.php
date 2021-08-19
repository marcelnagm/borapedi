
<style>
    
.hidden_field{
    display:none !important;
}
</style>
<div class="modal fade" id="modal-order-complete" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden_field="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-large" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-notification">Então</h3>                
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
                               
                                        <button class="btn btn-danger right" value="Proximo" onclick="show()" style="width: 100%;">Proximo</button>
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
                                        <div class="col-10">
                                                  @include('partials.fields',['fields'=>[
                                            ['ftype'=>'input','name'=>"Cep",'id'=>"cep2",'placeholder'=>"Seu cep aqui",'required'=>true]
                                            ]])                                          
                                        </div>
                                        <div class="col-1" style="padding-top: 30px;">
                                            <div class="row">
                                                <button type="button" style="width: 100%;" onclick="getAdd2()" >
                                                    <span class="input-group-text cep-label"><i id="search_location" class="fa fa-map-pin" data-toggle="tooltip" data-placement="top" title="" data-original-title="Get my current location"></i></span>
                                                </button>                                    
                                        </div>
                                            <div class="row">
                                                <a  alt="Não sei Meu Cef"  target="_blank"  href="https://buscacepinter.correios.com.br/app/endereco/index.php?t" class="btn-primary" style="width: 100%;background-color: revert !important;" ><img src="/images/icons/naosei.png"></a>
                                        </div>
                                        </div>

                                    </div>

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
                                    <input type="hidden_field"  name="phone_send"  id="phone_send" value="" > 
                                    <div class="row">
                                    <div class="col-12"> 
                                        <button class="btn btn-danger left" value="Proximo" onclick="hide()" style="width: 45%">Voltar</button>                                        
                                    <button type="button" id="submitNewAddress2" class="btn btn-success left" style="width: 50%">Concluir</button>    
                            </div>
                            </div>
                                    
                                    
                                </div>
                            </div>                                 
                        </div>
                    </div>
                </div>

                <div class="modal-footer">                
                    
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
                        }
                    }, error: function (response) {
                    }
                });
            });
        } else {
//                                                 Browser doesn't support Geolocation
//                                                handleLocationError(false, infoWindow, map.getCenter());
        }
    }
    function show() {
        var nome = $("#nome").val();
        if (nome.length < 1) {
             notify("\nPreencha o campo nome", 'error');
        }else{            
        $('#passo1').hide();
        $('#passo2').show();
        $("#submitNewAddress2").show();
        }        
    }
    ;
    function hide() {
        $('#passo1').show();
        $('#passo2').hide();

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
    }
    );


    </script>
