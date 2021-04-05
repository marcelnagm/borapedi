<div class="card card-profile shadow" id="addressBox">
    <div class="px-4">
      <div class="mt-5">
        <h3>{{ __('Delivery Info') }}<span class="font-weight-light"></span></h3>
      </div>
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
        
      </div>
      <br />
      <br />
    </div>
</div>
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
            crossorigin="anonymous"></script>
  <script>

        $(document).ready(function() {

            
            //Quando o campo cep perde o foco.
            $("#addressID").blur(function() {

                //Nova variável "cep" somente com dígitos.
                var cep = $(this).val().replace(/\D/g, '');
                cep = cep.replace('-', '');

                //Verifica se campo cep possui valor informado.
                if (cep != "") {
                    
                    //Expressão regular para validar o CEP.
                    var validacep = /^[0-9]{8}$/;

                    //Valida o formato do CEP.
                    if(validacep.test(cep)) {

                        //Preenche os campos com "..." enquanto consulta webservice.
                      
                        //Consulta o webservice viacep.com.br/
                        $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                            if (!("erro" in dados)) {
                                //Atualiza os campos com os valores da consulta.
                                console.log(dados);
                                $("#result_cep").text(dados.logradouro+' ,'+dados.bairro+' ,'+dados.localidade);
//                                $("#bairro").val(dados.bairro);
//                                $("#cidade").val(dados.localidade);
//                                $("#uf").val(dados.uf);
//                                $("#ibge").val(dados.ibge);
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