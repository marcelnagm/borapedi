@extends('layouts.app', ['title' => 'Whatsapp '])
@section('admin_title')
{{ config('settings.url_route')." ".__('Management')}}
@endsection
@section('content')
<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
</div>
<div class="container-fluid mt--7">
    <div class="row">
        <br/>
        <div class="card bg-secondary shadow col-lg-12">
            <div class="card-header bg-white border-0">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h3 class="mb-0">Whatsapp</h3>                            
                    </div>                       
                </div>
            </div>
            <div class="card-body bg-white border-0">
                Habilitar notificações de whatsapp <input type="checkbox" id='whatsapp'>
                <div id='qr_section' style="display: none;">
                    <h5>Escaneie o QR code</h5>
                    <input type="button" onclick="getQR();" class="btn btn-primary" value="Atualizar QR">
                    <p>Ao habilitar este recurso o sistema irá enviar notificações ao cliente
                        em relação ao pedido, mantenha este dispositivo ligado e conectado
                        para que este recurso funcione.</p>
                    <img id="qr" src="">
                </div>
                <br>
                <div class="table-responsive">
                    <a class="btn btn-primary" href="{{ route('whatsapp.new') }}">Adicionar mensagens personalizadas</a>
                    <table class="table align-items-center" id='result'>                           
                        @include('whatsapp.list')                            
                    </table>
                </div>
            </div>


        </div>
        @include('layouts.footers.auth')
    </div>
    @endsection

    @section('js')

    <script>
        $(document).ready(function ($) {
            //check if h
            $.ajax({
                type: 'POST',
                url: 'https://api.borapedi.com:3333/Status',
                dataType: 'json',
                data: {
                    SessionName: session,
//                        SessionName: "marcel",
                },
                success: function (response) {
                    console.log(response.result);
                    if (response.result == 'success') {
                        $("#whatsapp").prop("checked", true);
                    } else {
                        $("#whatsapp").prop("checked", false);
                    }
                }, error: function (response) {
                    //alert(response.responseJSON.errMsg);
                }
            });

            $("#whatsapp").change(function () {
                if (this.checked == true) {
                    $('#qr_section').show(30);
                    $.ajax({
                        type: 'POST',
                        url: 'https://api.borapedi.com:3333/Start',
//                        dataType: 'json',
                        data: {
                            SessionName: session,
//                        SessionName: "marcel",
                        },
                        success: function (response) {
                            console.log(response.result);
                            getQR();
//                            setInterval("atualizar_qrode()", 3000);

                        }, error: function (response) {
                            //alert(response.responseJSON.errMsg);
                        }
                    });

                } else {

                }

            });
        });



        var urlStatus = 'https://api.borapedi.com:3333/Status';
        var qrcod_lido = false;
        var session = "{{auth()->user()->restorant->phone}}";
        function atualizar_qrode() {
            if (!qrcod_lido) {
                $.post(urlStatus, {SessionName: session}, function (data) {
                    if ('inChat' == data.status) {
                        qrcod_lido = true
                    } else {
                        $.post('https://api.borapedi.com:3333/QRCode', {SessionName: session}, function (data) {
                            $("#qr").attr("src", data.qrcode);
                        }, "json");
                    }
                });
            }
        }

        // Definindo intervalo que a função será chamada



        function getQR() {
            $("#qr").attr("src", '');
            $.post('https://api.borapedi.com:3333/QRCode',
                    {SessionName: "{{auth()->user()->restorant->phone}}"
                        , View: false},
                    function (data) {
                        $("#qr").attr("src", data.qrcode);
                    }, "json");

        }
    </script>

    @endsection

