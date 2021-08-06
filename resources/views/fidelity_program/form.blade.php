
<div class='reward_box'>
<div class="row">
    <div class="col-lg-12">
        @if(isset($fidelity))
        @include('partials.select',['classselect'=>"col-12 noselecttwo", 'ftype'=>'input','name'=>"type_target",'id'=>"type_target",'placeholder'=>"Como será computado o objetivo",'data' => [0 =>'Com base em pedidos',1=>'Com base em gastos'],'required'=>true, 'value'=>$fidelity->type_target])
        @else
        @include('partials.select',['classselect'=>"col-12 noselecttwo", 'ftype'=>'input','name'=>"type_target",'id'=>"type_target",'placeholder'=>"Como será computado o objetivo",'data' =>[ 0 =>'Com base em pedidos',1=>'Com base em gastos'],'required'=>true])
        @endif
    </div>
</div>        
<div class="row">
    <div class="col-lg-12">
        @if(isset($fidelity))
        @include('partials.input',['class'=>"col-12 target-orders", 'ftype'=>'input','name'=>"target_orders",'id'=>"target_orders",'placeholder'=>"Quantos Pedidos?",'required'=>true, 'value'=>$fidelity->target_orders])
        @include('partials.input',['class'=>"col-12", 'ftype'=>'input','name'=>"target_value",'id'=>"target_value",'placeholder'=>"Valor por Pedido?",'required'=>true, 'value'=>$fidelity->target_value])
        @else
        @include('partials.input',['class'=>"col-12 target-orders", 'ftype'=>'input','name'=>"target_orders",'id'=>"target_orders",'placeholder'=>"Quantos Pedidos?",'required'=>true ])
        @include('partials.input',['class'=>"col-12", 'ftype'=>'input','name'=>"target_value",'id'=>"target_value",'placeholder'=>"Valor por Pedido?",'required'=>true])
        @endif
    </div>
</div>  
</div>  
<div class='reward_box reward_box_last'>
<div class="row">
    <div class="col-lg-12">
        @if(isset($fidelity))
        @include('partials.select',['classselect'=>"col-12 noselecttwo", 'ftype'=>'input','name'=>"type_reward",'id'=>"type_reward",'placeholder'=>"Como será computado o objetivo",'data' => ['Cupom de desconto','Item Grátis'],'required'=>true, 'value'=>$fidelity->type_reward])
        @else
        @include('partials.select',['classselect'=>"col-12 noselecttwo", 'ftype'=>'input','name'=>"type_reward",'id'=>"type_reward",'placeholder'=>"Como será computado o objetivo",'data' => ['Cupom de desconto','Item Grátis'],'required'=>true])
        @endif
    </div>
</div>        
<div class="row">
    <div class="col-lg-12">
        @if(isset($fidelity))
        @include('partials.input',['class'=>"col-12 reward", 'ftype'=>'input','name'=>"reward",'id'=>"reward",'placeholder'=>"prêmio",'required'=>true, 'value'=>$fidelity->reward])
        @else
        @include('partials.input',['class'=>"col-12 reward", 'ftype'=>'input','name'=>"reward",'id'=>"reward",'placeholder'=>"prêmio",'required'=>true])
        @endif
    </div>
</div>     
<div class="row">
    <div class="col-lg-12">
        @if(isset($fidelity))
        @include('partials.select', ['classselect'=>"col-12 noselecttwo type",'name'=>"type_coupon",'id'=>"type_coupon",'placeholder'=>"Select type",'data'=>['Fixed', 'Percentage'],'required'=>true, 'value'=>$fidelity->type_coupon])
        @else
        @include('partials.select', ['classselect'=>"col-12 noselecttwo type",'name'=>"type_coupon",'id'=>"type_coupon",'placeholder'=>"Select type",'data'=>['Fixed', 'Percentage'],'required'=>true])
        @endif
    </div>
</div>        
</div>  
<div class="row">
    <div class="col-lg-12">
        @if(isset($fidelity))
        @include('partials.bool', ['class'=>"col-12",'name'=>"Active",'id'=>"active",'placeholder'=>"Ativo?",'required'=>true, 'value'=>$fidelity->getActive()])
        @else
        @include('partials.bool', ['class'=>"col-12",'name'=>"Active",'id'=>"active",'placeholder'=>"Ativo?",'required'=>true])
        @endif
    </div>
</div>        
<input name="restaurant_id" value="{{ auth()->user()->restorant()->first()->id}}" type="hidden"> 
<style>
    .reward_box{
        border: #11cdef groove 2px;
        padding: 10px;
    }
    .reward_box_last{
        border-top:none;
    }
    
</style>
    

@section('js')
<script>


                @if(isset($fidelity))
                select_type_reward( {{$fidelity->type_reward}});
                select_type_target({{$fidelity->type_target}});
                @endif
    $('#type_target').change(function () {        
        select_type_target($('#type_target').find(":selected").text()); 
    });
    $('#type_reward').change(function () {
       select_type_reward($('#type_reward').find(":selected").text());
    });
    
    function select_type_reward(type_reward){
         if (type_reward === 'Item Grátis' || type_reward ===1) {
            $('.reward').hide(1);
            $('#form-group-type_coupon').hide(1);
        } else {
            $('.reward').show(1);
            $('#form-group-type_coupon').show(1);
        }
    }
    function select_type_target(type_target){
        if (type_target === 'Com base em gastos' || type_target=== 1) {
            $('.target-orders').hide(1);
            $('#target-orders').val(1);
        } else {
            $('.target-orders').show(1);
        }
    }
    
</script>

@endsection