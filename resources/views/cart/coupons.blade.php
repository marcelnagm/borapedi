<h6>Cupom</h6>
<div class="row">
    <div class="col-8">
        <div class="form-group">
               <select id="cupom_combo" class="" onchange="cupom(this)">
                    <option value='' >Selecione um cupom</option>
                    @foreach($cupons as $cupom)
                    
                    @if ($cupom->used_count < $cupom->limit_to_num_uses)
                    <option value='{{$cupom->code}}' >Cupom de {{ $cupom->type == 0 ? $cupom->price." ".config('settings.cashier_currency') : $cupom->price." %"}} </option>
                    @endif
                    @endforeach
               </select>     
            <input type="hidden" class="form-control" id="coupon_code" name="coupon_code" placeholder="{{ __('Enter your promo code here') }}" >        
            <button type="button" id="promo_code_btn" class="btn btn-danger btn-sm">{{ __('Apply') }}</button>        
        </div>
    </div>
</div><div class="row">
    <div class="col-12">        
        <span>Apenas um cupom por pedido</span>                     
    </div>

</div>
<div class="text-center">
    <span><i id="promo_code_succ" class="ni ni-check-bold text-success"></i></span>
    <span><i id="promo_code_war" class="ni ni-fat-remove text-danger"></i></span>
</div> 

  <script>
        function cupom(e) {
            var optionSelected = $("option:selected", e);
            var valueSelected = e.value;
            $("#coupon_code").val(valueSelected); 
        }


        // function payment (e) {

        //)

    </script>