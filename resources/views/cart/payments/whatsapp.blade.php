<br />
<?php if (auth()->user()->phone == "") { ?>
    <script>
        var no_phone = false;        
    </script>    
    <button type="button" data-toggle="modal" data-target="#modal-new-phone"  class="btn btn btn-danger my-4text-right">
        Enviar Pedido</button>
    <br>
    <br>
<?php } else { ?>
    <script>
        var no_phone = true;
    </script>  
    <div class="text-center" id="totalSubmitCOD">
        <button 

            v-if="totalPrice"
            type="button"
            class="btn btn-lg btn-icon btn-danger my-4 paymentbutton"
            onclick="document.getElementById('order-form').submit()"
            >

            <span class="btn-inner--icon lg"><i class="fa fa-whatsapp" aria-hidden="true"></i></span>
            <span class="btn-inner--text">{{ __('Send Whatsapp Order') }}</span>
            
    </div>
<?php } ?>
