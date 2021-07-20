<div class="modal fade" id="modal-money-change" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-large" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-notification">Vai precisar de troco</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <div class="card bg-secondary shadow border-l-4">
                    <div class="card-content border-top">
                        <br />                            
                            <div class="row">
                            
                            <div class="col-6" style="padding-left: 30px;">
                                <div id="form-group-money_change" class="form-group  ">
             <label class="form-control-label" for="money_change">Troco para quanto?</label>
             <select name="money_change" id="money_change" name="money_change" id="money_change" class="form-control form-control  noselecttwo   " >
                 <option value="0" default>
                     Tenho o valor integral
                 </option>
                 <option value="10">
                     10
                 </option>
                 </option>
                 <option value="20">
                     20
                 </option>
                 <option value="50">
                     50
                 </option>
                 <option value="100">
                     100
                 </option>
             </select>
        </div>
                                                    </div>

                        </div>
                        </div>
                        <div class="row"> 
                            <div class="col-12">
                                <div class="custom-control custom-checkbox mb-3">
                                    <input class="custom-control-input" id="privacypolicy" type="checkbox" checked>
                                    <label class="custom-control-label" for="privacypolicy">
                                        <b > Concordar em receber mensagens do Whatsapp</b>
                                        <p>Você receberá notificações do estabelecimento por WhatsApp sobre o seu pedido.</p>
                                    </label>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>                
                <div class="modal-footer ">
                    <div class="text-center" id="totalSubmitCOD" style="display:block !important;">
                        <button 

                            v-if="totalPrice"
                            type="submit"
                            class="btn btn-lg btn-icon btn-success mt-4 "
                            onclick="form.submit();"

                            >

                            <span class="btn-inner--icon lg"><i class="fa fa-whatsapp" aria-hidden="true"></i></span>
                            <span class="btn-inner--text">{{ __('Send Whatsapp Order') }}</span>
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