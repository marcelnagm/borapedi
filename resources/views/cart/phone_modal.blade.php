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
                            <div class="col-4" style="padding-left: 30px;">
                                @include('partials.fields',['fields'=>[
                                ['ftype'=>'input','name'=>"Whatsapp",'id'=>"phone",'placeholder'=>"Coloque seu Whatsapp aqui ...",'required'=>true],
                                ]])
                            </div>

                        </div>
                        <div class="row"> 
                            <div class="col-6">
                                <div class="custom-control custom-checkbox mb-3">
                                    <input class="custom-control-input" id="privacypolicy" type="checkbox">
                                    <!--<label class="custom-control-label" for="privacypolicy">{{ __('I agree to the Terms and Conditions and Privacy Policy') }}</label>-->
                                    <label class="custom-control-label" for="privacypolicy">
                                        &nbsp;&nbsp;{{__('I agree to the')}}
                                        <a href="{{config('settings.link_to_ts')}}" target="_blank" style="text-decoration: underline;">{{__('Terms of Service')}}</a> {{__('and')}}
                                        <a href="{{config('settings.link_to_pr')}}" target="_blank" style="text-decoration: underline;">{{__('Privacy Policy')}}</a>.
                                    </label>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>                
                <div class="modal-footer">
                    <div class="text-center" id="totalSubmitCOD">
                        <button 

                            v-if="totalPrice"
                            type="submit"
                            class="btn btn-lg btn-icon btn-success mt-4 paymentbutton"
                            onclick="this.disabled = true;this.form.submit();"
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