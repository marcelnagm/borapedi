<?php if (auth()->user()->phone == "") { ?>
    <div class="">

        <script>
            var no_phone = false;
        </script> 
        
        <button type="button" data-toggle="modal" data-target="#modal-new-phone"  class="button_disabled_custom button_finalizar_pedido btn my-4 text-right">        
            <span class="btn-inner--icon lg"><i class="fa fa-whatsapp" aria-hidden="true"></i></span>
            <span class="btn-inner--text">Próximo</span>

        </button>
        
    </div>
<?php } else { ?>
    <script>
        var no_phone = true;
    </script>  
        <button 
            style=""
            v-if="totalPrice"
            type="button"
            class="button_disabled_custom button_finalizar_pedido btn-icon btn my-4 paymentbutton"
            onclick="document.getElementById('order-form').submit()"
            >

            <span class="btn-inner--icon lg"><i class="fa fa-whatsapp" aria-hidden="true"></i></span>
            <span class="btn-inner--text">Realizar Pedido</span>

<?php } ?>