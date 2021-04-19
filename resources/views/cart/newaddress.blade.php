<div class="card card-profile shadow" id="addressBox">
    <div class="px-4">
      <div class="mt-5">
        <h3>{{ __('Delivery Info') }}<span class="font-weight-light"></span></h3>
      </div>
      <div class="card-content border-top">
        <br />
        <div class="card-content border-top">
            <br />
            @include('partials.fields',['fields'=>[
            ['ftype'=>'input','name'=>"cep",'id'=>"addressID",'placeholder'=>"Coloque seu CEP aqui ...",'required'=>true],
            ]])
            <div id="result_cep" readonly="true" class="card-content">

            </div>
            @include('partials.fields',['fields'=>[            
            ['ftype'=>'input','name'=>"number",'id'=>"numbero",'placeholder'=>"Numero",'required'=>true],
            ['ftype'=>'input','name'=>"complement",'id'=>"addressID",'placeholder'=>"Apartamento, Casa, e etc..'",'required'=>true]
            ]])
            40
        </div>
      </div>
      <br />
      <br />
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
crossorigin="anonymous"></script>
<script>

$(document).ready(function () {


//Quando o campo cep perde o foco.
    $("#addressID").blur(function () {

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
                        $("#result_cep").text(dados.logradouro + ' ,' + dados.bairro + ' ,' + dados.localidade);//                   
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
    $("#numbero").blur(function () {

//Nova variável "cep" somente com dígitos.
        var cep = $('#result_cep').html();
        var numero = $("#numbero").val();
        var add = $("#rid").html();
        var id_rest = <?php echo $restorant->id ?>;
        console.log(cep + ' ,' + numero);
//        event.preventDefault();
//
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: '/find-cep',
            dataType: 'json',
            data: {
                r_id: id_rest,
                address: cep + ' ,' + numero,
                address_rid: add

            },
            success: function (response) {
//                alert('sucess');
                console.log(response.text);
                
                if (response.status == false) {

                    $('#totalSubmitCOD').hide(1);
                    alert(response.message);
                }
                if (response.status == true) {
//                    alert(response.tax);
                    $('#deliveryTax').html("<strong>R$"+response.tax+"</strong>");                    
                }
//                      $("#result").html(response);
            }, error: function (response) {
                //alert(response.responseJSON.errMsg);
            }
        })
    });

});

</script>  