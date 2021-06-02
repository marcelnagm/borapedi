<div class="row">
    <div class="col-md-6">
        @if(isset($coupon))
        @include('partials.input',['class'=>"col-12", 'ftype'=>'input','name'=>"Name",'id'=>"name",'placeholder'=>"Nome do classificação Ex- prata,ouro",'required'=>true, 'value'=>$coupon->name])
        @else
        @include('partials.input',['class'=>"col-12", 'ftype'=>'input','name'=>"Name",'id'=>"name",'placeholder'=>"Nome do classificação Ex- prata,ouro",'required'=>true])
        @endif
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        @if(isset($coupon))
        @include('partials.input',['class'=>"col-12", 'ftype'=>'input','name'=>"Periodo",'id'=>"Meses",'placeholder'=>"Preencha quantos meses a considerar",'required'=>true, 'value'=>$coupon->period])
        @else
        @include('partials.input',['class'=>"col-12", 'ftype'=>'input','name'=>"Periodo",'id'=>"Meses",'placeholder'=>"Preencha quantos meses a considerar",'required'=>true])
        @endif
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        @if(isset($coupon))
        @include('partials.input',['class'=>"col-12", 'ftype'=>'input','name'=>"Val",'id'=>"Val",'placeholder'=>"Valor Gasto em Reais",'required'=>true, 'value'=>$coupon->val])
        @else
        @include('partials.input',['class'=>"col-12", 'ftype'=>'input','name'=>"Val",'id'=>"Val",'placeholder'=>"Valor Gasto em Reais",'required'=>true])
        @endif
    </div>


</div>