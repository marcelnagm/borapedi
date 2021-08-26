<div class="pl-lg-4">
    <form id="restorant-form" method="post" action="{{ route('admin.restaurants.update', $restorant) }}" autocomplete="off" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="row">
            <div class="col-md-6">
                <input type="hidden" id="rid" value="{{ $restorant->id }}"/>
                @include('partials.fields',['fields'=>[
                ['ftype'=>'input','name'=>"Restaurant Name",'id'=>"name",'placeholder'=>"Restaurant Name",'required'=>true,'value'=>$restorant->name],
                    ['ftype'=>'input','name'=>"Subdomĩnio",'id'=>"subdomain",'placeholder'=>"Um nome curto para identificar o restaurante",'help' => 'Este campo se refere ao um nome para identificar unicamente o seu restaurante da mesma forma que o exemplo, Ex: [blend-pizza].borapedi.com .Este link que você deverá compartilhar entre seus clientes',
                'required'=>true,'value'=>$restorant->subdomain],
                ['ftype'=>'input','help' => 'Descrição que aparecerá para o cliente conhecer o seu restaurante, uma boa prática é colocar uma descrição do tipo de cozinha que é servido
                ','name'=>"Restaurant Description",'id'=>"description",'placeholder'=>"Restaurant description",'required'=>true,'value'=>$restorant->description],
                ]])
                <div class="row" style="margin-bottom:10px;">
                    <div class="col-12">
                        <div id="form-group-cep" class="form-group  ">
                            <label class="form-control-label cep-label" for="cep" style="position: relative; top: -22px;">Cep:</label>
                            <input step=".01" type="text" name="Cep" id="cep" class="form-control form-control cep-form  " placeholder="Coloque seu CEP aqui ..." value="" autofocus="">
                            <button type="button" style="float:left; " onclick="getAdd()">
                                <span class="input-group-text cep-label"><i id="search_location" class="fa fa-map-pin" data-toggle="tooltip" data-placement="top" title="" data-original-title="Get my current location"></i></span>
                            </button>                                    
                            <a  alt="Não sei Meu Cef"  target="_blank"  href="https://buscacepinter.correios.com.br/app/endereco/index.php?t" class="btn-primary" style="float: left; " ><img src="/images/icons/naosei.png"></a>
                        </div>                                                                 
                    </div>                               
                    <p>Este campo não fica preenchido sendo apenas uma ferramentar para selecionar o endereço corretamente</p>
                </div>
                @include('partials.fields',['fields'=>[
                ['ftype'=>'input','name'=>"Restaurant Address",'id'=>"address",'placeholder'=>"Restaurant address",'required'=>true,'value'=>$restorant->address],
                ['ftype'=>'input','help' => 'Número do whatsapp do restaurante, não necessáriamente é o mesmo do contato, este número será utilizado para entrar em contato com os clientes e aparecerá na tela de contato do restaurante','name'=>"Whatsapp do Restaurante",'id'=>"whatsapp_phone",'placeholder'=>"Restaurant phone",'required'=>true,'value'=>$restorant->whatsapp_phone],
                ['ftype'=>'input','help' => 'Telefone de contato do restaurante','name'=>"Restaurant Phone",'id'=>"phone",'placeholder'=>"Restaurant phone",'required'=>true,'value'=>$restorant->phone],
                ]])

                @if(config('settings.multi_city'))
                @include('partials.fields',['fields'=>[
                ['ftype'=>'select','name'=>"Restaurant city",'id'=>"city_id",'data'=>$cities,'required'=>true,'value'=>$restorant->city_id],
                ]])
                <p>Se não aparece a sua cidade,peça a inclusão 
                    <a href="mailto:suporte@4sconnect.com.br" >aqui</a>
                </p>
                @endif

                @if(auth()->user()->hasRole('admin'))
                <br/>
                <div class="row">
                    <div class="col-6 form-group{{ $errors->has('fee') ? ' has-danger' : '' }}">
                        <label class="form-control-label" for="input-description">{{ __('Fee percent') }}</label>
                        <input type="number" name="fee" id="input-fee" step="any" min="0" max="100" class="form-control form-control-alternative{{ $errors->has('fee') ? ' is-invalid' : '' }}" value="{{ old('fee', $restorant->fee) }}" required autofocus>
                        @if ($errors->has('fee'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('fee') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="col-6 form-group{{ $errors->has('static_fee') ? ' has-danger' : '' }}">
                        <label class="form-control-label" for="input-description">{{ __('Static fee') }}</label>
                        <input type="number" name="static_fee" id="input-fee" step="any" min="0" max="100" class="form-control form-control-alternative{{ $errors->has('static_fee') ? ' is-invalid' : '' }}" value="{{ old('static_fee', $restorant->static_fee) }}" required autofocus>
                        @if ($errors->has('static_fee'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('static_fee') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <br/>
                <div class="form-group">
                    <label class="form-control-label" for="item_price">{{ __('Is Featured') }}</label>
                    <label class="custom-toggle" style="float: right">
                        <input type="checkbox" name="is_featured" <?php
                        if ($restorant->is_featured == 1) {
                            echo "checked";
                        }
                        ?>>
                        <span class="custom-toggle-slider rounded-circle"></span>
                    </label>
                </div>
                <br/>
                @endif
                <br/>                
                @if(config('app.isft'))
                                
                @include('partials.fields',['fields'=>[
                ['ftype'=>'bool','help'=>'Habilita a opção de retirada no local','name'=>"Pickup",'id'=>"can_pickup",'value'=>$restorant->can_pickup == 1 ? "true" : "false"],
                ]])
                @include('partials.fields',['fields'=>[               
                ['ftype'=>'bool','help'=>'Habilita o sistema de entrega em domicílio','name'=>"Delivery",'id'=>"can_deliver",'value'=>$restorant->can_deliver == 1 ? "true" : "false"],
                ]])
                @include('partials.fields',['fields'=>[
                ['ftype'=>'bool','help'=>'Habilita a opção de consumo no local por mesa e atendimento por garçom','name'=>"Self Delivery",'id'=>"self_deliver",'value'=>$restorant->self_deliver == 1 ? "true" : "false"],
                ]])
                @include('partials.fields',['fields'=>[
                ['ftype'=>'bool','help'=> 'Torna gratuíta a taxa de entrega','name'=>"Free Delivery",'id'=>"free_deliver",'value'=>$restorant->free_deliver == 1 ? "true" : "false"],
                ]])
                @elseif(config('app.isqrsaas') && !config('settings.is_whatsapp_ordering_mode'))
                @include('partials.fields',['fields'=>[
                ['ftype'=>'bool','name'=>"Disable Call Waiter",'id'=>"disable_callwaiter",'value'=>$restorant->getConfig('disable_callwaiter', 0) ? "true" : "false"],
                ]])
                @endif  
                <br/>
                <div class="row">
                    <?php
                    $images = [
                        ['name' => 'resto_wide_logo', 'label' => __('Restaurant wide logo'), 'value' => $restorant->logowide, 'style' => 'width: 200px; height: 62px;', 'help' => "PNG 650x120 recomended"],
                        ['name' => 'resto_wide_logo_dark', 'label' => __('Dark restaurant wide logo'), 'value' => $restorant->logowidedark, 'style' => 'width: 200px; height: 62px;', 'help' => "PNG 650x120 recomended"],
                        ['name' => 'resto_logo', 'label' => __('Restaurant Image'), 'value' => $restorant->logom, 'style' => 'width: 295px; height: 200px;', 'help' => "JPEG 590 x 400 recomended"],
                        ['name' => 'resto_cover', 'label' => __('Restaurant Cover Image'), 'value' => $restorant->coverm, 'style' => 'width: 200px; height: 100px;', 'help' => "JPEG 2000 x 1000 recomended"]
                            ]
                    ?>
                    @foreach ($images as $image)
                    <div class="col-md-6">
                        @include('partials.images',$image)
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="col-md-6">
                @include('restorants.partials.ordering')
                @include('restorants.partials.localisation')

                <!-- WHATS APP MODE -->
                @if (config('settings.is_whatsapp_ordering_mode'))
                @include('restorants.partials.social_info')  
                @endif

                @if (config('settings.whatsapp_ordering'))
                <!-- We have WP ordering -->
                @if (config('app.isft'))
                <!-- FT -->
                @if(auth()->user()->hasRole('admin'))
                @include('restorants.partials.waphone')
                @endif
                @else
                <!-- QR -->
                @include('restorants.partials.waphone')
                @endif
                @endif

            </div>

        </div>


        <div class="text-center">
            <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
        </div>

    </form>
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
                                                        $("#address").val(response.data.address_components[1]['long_name'] + " " + response.data.address_components[0]['long_name'] + ", " + response.data.address_components[2]['long_name'] + " -" + response.data.address_components[3]['long_name'] + ' - ' + response.data.address_components[4]['long_name']);
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
                                                        console.log(dados);
                                                        $("#address").val(dados.logradouro + " ," + dados.bairro + " -" + dados.localidade);

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