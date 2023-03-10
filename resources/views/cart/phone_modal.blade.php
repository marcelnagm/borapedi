<div class="modal fade" id="modal-new-phone" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-large" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-notification">{{ "Complete o se cadatro para finalizar o pedido" }}</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <div class="card bg-secondary shadow border-l-4">
                    <div class="card-content border-top">
                        <br />
                        <div class="row">
                            <div class="col-12" style="padding-left: 30px;">
                                @include('partials.fields',['fields'=>[
                                ['ftype'=>'input','name'=>"Whatsapp",'id'=>"phone",'placeholder'=>"Coloque seu Whatsapp aqui ...",'required'=>true],
                                ]])
                            </div>

                        </div>
                        <div class="row"> 
                            <div class="col-6">
                                <div class="custom-control custom-checkbox mb-3">
                                    <input class="custom-control-input" id="privacypolicy" type="checkbox">
                                    <label class="custom-control-label" for="privacypolicy">
                                        <b > Concordar em receber mensagens do Whatsapp</b>
                                        <p>Você receberá notificações do estabelecimento por WhatsApp sobre o seu pedido.</p>
                                    </label>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>                
                <div class="modal-footer">                    
                    <div class="text-center" id="totalSubmitCOD" style="display:block !important;">
                    <button 
            style=""
            v-if="totalPrice"
            type="button"
            class="btn btn-icon btn-danger my-4 paymentbutton"
            onclick="document.getElementById('order-form').submit()"
            >

            <span class="btn-inner--icon lg"><i class="fa fa-whatsapp" aria-hidden="true"></i></span>
            <span class="btn-inner--text">Realizar Pedido</span>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>

<script>
                                $(document).ready(function ($) {
                                    $("#phone").mask("(00) 00000-0000");
                                    $("#phone").blur(function () {
//                  alert('mudou');
                                        $("#phone_send").val($("#phone").val());
                                    });
                                });


</script>