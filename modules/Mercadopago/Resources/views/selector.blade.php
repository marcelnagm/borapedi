@if (
    (config('mercadopago.useAdmin')&&config('mercadopago.access_token')!=""&&config('mercadopago.enabled')) ||
    (config('mercadopago.useVendor')&&strlen($restorant->getConfig('mercadopago_access_token',""))>3&&$restorant->getConfig('mercadopago_enable','false')!='false')
)
        <option name="paymentType" class="custom-control-input" id="paymentMercadopago" type="radio" value="mercadopago" {{ config('settings.default_payment')=="mercadopago"?"checked":""}}>
            {{ __('Pay with Mercadopago') }}</option>
    
@endif