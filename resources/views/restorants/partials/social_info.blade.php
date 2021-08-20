<br />
<h6 class="heading-small text-muted mb-4">{{ __('Accepting Payments') }}</h6>
<!-- Payment explanation -->
@include('partials.fields',['fields'=>[
    ['required'=>false,'ftype'=>'input','placeholder'=>"Payment info",'name'=>'Payment info', 'additionalInfo'=>'ex. We accept cash on delivery and cash on pick up', 'id'=>'payment_info', 'value'=>$restorant->payment_info]
]])
@include('partials.fields',['fields'=>[
['ftype'=>'bool','name'=>"Pagamento na Entrega?",'id'=>"restorant_hide_ondelivery",'value'=>($restorant->getConfig('restorant_hide_ondelivery') == 1 ? "true" : "false")],
]])
@include('partials.fields',['fields'=>[
['ftype'=>'bool','name'=>"Pagamento Dinheiro na Entrega",'id'=>"restaurant_hide_cod",'value'=>($restorant->getConfig('restaurant_hide_cod') == 1 ? "true" : "false")],
['ftype'=>'bool','name'=>"Pagamento Máquina de Cartão na Entrega?",'id'=>"restaurant_hide_card",'value'=>($restorant->getConfig('restaurant_hide_card') == 1 ? "true" : "false")],
]])

