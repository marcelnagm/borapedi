<style>
    .cep-form{
            float: left;
    width: 78% !important;
    }
    .cep-label{
            float: left;
            height: 20px;
    }
    
</style>


<div class="modal fade" id="modal-order-new-address" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-large" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-notification">{{ 'Novo Endereço de Entrega' }}</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <div class="card bg-secondary shadow border-0">
                    <div class="card-body px-lg-5 py-lg-5" id="new_address_checkout_body">
                        <div class="card-content border-top">
                            <br />
                            <div class="row" style="margin-bottom:10px;">
                                <div class="col-12">
                                    <div id="form-group-cep" class="form-group  ">
                                        <label class="form-control-label cep-label" for="cep" >Cep: <a  alt="Não sei Meu Cef"  target="_blank"  href="https://buscacepinter.correios.com.br/app/endereco/index.php?t" style="font-style: italic;" >Não sei <i class="fas fa-question-circle"></i></a></label>
                                        </br>
                                        </br>
                                        <input  type="text" name="Cep" id="cep" class="form-control form-control cep-form  " placeholder="Coloque seu CEP aqui ..." required="" autofocus="" style="width:95% !important;"> 
                                        <button type="button" style="float:left; width: 5%;height:40px;" onclick="getAdd()">
                                        <span class="input-group-text cep-label" style="float:left; width: 10%;height:40px"><i id="search_location" class="fa fa-map-pin" data-toggle="tooltip" data-placement="top" title="" data-original-title="Pegar minha localização"></i></span>
                                        </button>   
                                    </div> 
                                        
                                    </div>                                                                 
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    @include('partials.fields',['fields'=>[
                                    ['ftype'=>'input','name'=>"Apelido",'id'=>"nick",'placeholder'=>"Casa,Trabalho, Casa do Amigo",'required'=>true]
                                    ]])    
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">                           
                                    @include('partials.fields',['fields'=>[
                                    ['ftype'=>'input','name'=>"Logradouro",'id'=>"address",'placeholder'=>"",'required'=>true,'readonly' => true]
                                    ]])                         
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    @include('partials.fields',['fields'=>[
                                    ['ftype'=>'input','name'=>"Bairro",'id'=>"address_neigh",'placeholder'=>"",'required'=>true,'readonly' => true]
                                    ]])
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    @include('partials.fields',['fields'=>[
                                    ['ftype'=>'input','name'=>"Cidade/Estado",'id'=>"address_city",'placeholder'=>"",'required'=>true,'readonly' => true]
                                    ]])
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    @include('partials.fields',['fields'=>[            
                                    ['ftype'=>'input','name'=>"Número",'id'=>"numbero",'placeholder'=>"Numero",'required'=>true],
                                    ]])
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    @include('partials.fields',['fields'=>[            
                                    ['ftype'=>'input','name'=>"Complemento",'id'=>"complement",'placeholder'=>"Apartamento, Casa, e etc..'",'required'=>true]
                                    ]])   </div>
                            </div>
                            <input type="hidden"  name="phone_send"  id="phone_send" value="" > 
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-link" data-dismiss="modal">{{ __('Close') }}</button>
                <button type="button" id="submitNewAddress" class="btn btn-success">{{ __('Save') }}</button>
            </div>

        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
crossorigin="anonymous"></script>
<script>

                                        function getAdd() {
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
                                                                $("#txtlocation").val(response.data.formatted_address);
                                                                $("#address").val(response.data.address_components[1]['long_name']);
                                                                $("#address_neigh").val(response.data.address_components[2]['long_name']);
                                                                $("#address_city").val(response.data.address_components[3]['long_name'] + ' - ' + response.data.address_components[4]['long_name']);
                                                                $("#numbero").val(response.data.address_components[0]['long_name']);
                                                                $("#cep").val(response.data.address_components[6]['long_name']);
                                                                $("#submitNewAddress").show();
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


                                        $(document).ready(function ($) {

                                            //Quando o campo cep perde o foco.
                                            $("#cep").blur(function () {
//Nova variável "cep" somente com dígitos.
                                                var cep = $(this).val().replace(/\D/g, '');
                                                cep = cep.replace('-', '');
                                                $("#numbero").val('');
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
                                                                $("#address").val(dados.logradouro);
                                                                $("#address_neigh").val(dados.bairro);
                                                                $("#address_city").val(dados.localidade + ' - ' + dados.uf);
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