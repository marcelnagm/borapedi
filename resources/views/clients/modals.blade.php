<div class="modal fade" id="modal-order-new-address" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-large" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-notification">{{ __('Add new address') }}</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <div class="card bg-secondary shadow border-0">
                    <div class="card-body px-lg-5 py-lg-5" id="new_address_checkout_body">
                        <div class="card-content border-top">
                            <br />
                            <div class="row">
                                <div class="col-6">
                                    @include('partials.fields',['fields'=>[
                                    ['ftype'=>'input','name'=>"cep",'id'=>"cep",'placeholder'=>"Coloque seu CEP aqui ...",'required'=>true]
                                    ]])
                                </div>
                                <div class="col-4">
                                    </br>                                    
                                    <a  alt="Não sei Meu Cef"  target="_blank"  href="https://buscacepinter.correios.com.br/app/endereco/index.php?t" class="btn btn-primary" >Não sei meu CEP</a>                                    
                                    <div class="input-group mb-4">                                        
                                        <div type="button" class="input-group-append button">
                                            <span class="input-group-text"><i id="search_location" class="fa fa-map-pin" data-toggle="tooltip" data-placement="top" title="" data-original-title="Get my current location"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @include('partials.fields',['fields'=>[
                            ['ftype'=>'input','name'=>"Logradouro",'id'=>"address",'placeholder'=>"",'required'=>true,'readonly' => true],
                            ['ftype'=>'input','name'=>"Bairro",'id'=>"address_neigh",'placeholder'=>"",'required'=>true,'readonly' => true],
                            ['ftype'=>'input','name'=>"Cidade/Estado",'id'=>"address_city",'placeholder'=>"",'required'=>true,'readonly' => true]
                            ]])

                            @include('partials.fields',['fields'=>[            
                            ['ftype'=>'input','name'=>"number",'id'=>"numbero",'placeholder'=>"Numero",'required'=>true],
                            ['ftype'=>'input','name'=>"complement",'id'=>"complement",'placeholder'=>"Apartamento, Casa, e etc..'",'required'=>true]
                            ]])
                            <input type="hidden"  name="phone_send"  id="phone_send" value="" > 
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-link" data-dismiss="modal">{{ __('Close') }}</button>
                <button type="button" id="submitNewAddress" class="btn btn-outline-success">{{ __('Save') }}</button>
            </div>

        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
crossorigin="anonymous"></script>
<script>

$(document).ready(function ($) {

//$('#numbero').keypress(function () {
//        $("#submitNewAddress").show();
//    });

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
});

</script>   