<br />
<h4 class="heading-small text-muted mb-4">Outras formas de pagamento</h4>
<!-- Payment explanation -->
@include('partials.fields',['fields'=>[
    ['required'=>false,'ftype'=>'input','placeholder'=>"Payment info",'name'=>'Payment info', 'additionalInfo'=>'ex. We accept cash on delivery and cash on pick up', 'id'=>'payment_info', 'value'=>$restorant->payment_info]
]])
@include('partials.fields',['fields'=>[
['ftype'=>'bool','help'=> 'Habilita a opção de pagamento na entrega, geralmente quando você possui motoboy próprio','name'=>"Pagamento na Entrega?",'id'=>"restorant_hide_ondelivery",'value'=>($restorant->getConfig('restorant_hide_ondelivery') == 1 ? "true" : "false")],
]])
@include('partials.fields',['fields'=>[
['ftype'=>'bool','help'=> 'Habilita a opção de pagar em dinheiro na entrega','name'=>"Pagamento Dinheiro na Entrega",'id'=>"restaurant_hide_cod",'value'=>($restorant->getConfig('restaurant_hide_cod') == 1 ? "true" : "false")],
['ftype'=>'bool','help'=> 'Habilita a opção de pagar na máquina de cartão na entrega','name'=>"Pagamento Máquina de Cartão na Entrega?",'id'=>"restaurant_hide_card",'value'=>($restorant->getConfig('restaurant_hide_card') == 1 ? "true" : "false")],
['ftype'=>'bool','help'=> 'Habilita a opção de coupons em seu restaurante. ATENÇÃO- Lembre-se de ativar esta opção em caso de habilitar o programa de fidelidade','name'=>"Habilitar coupons?",'id'=>"restaurant_no_coupom",'value'=>($restorant->getConfig('restaurant_no_coupom') == 1 ? "true" : "false")],
]])

