    <h6>Cupom</h6>
    <div class="row">
<div class="col-8">
    <div class="form-group">
        <input type="text" class="form-control" id="coupon_code" name="coupon_code" placeholder="{{ __('Enter your promo code here') }}">        
        <button type="button" id="promo_code_btn" class="btn btn-danger btn-sm">{{ __('Apply') }}</button>        
    </div>
    </div>
<div class="col-md-3">        
     <span>Apenas um cupom por pedido</span>                     
</div>
   
</div>
<div class="text-center">
    <span><i id="promo_code_succ" class="ni ni-check-bold text-success"></i></span>
    <span><i id="promo_code_war" class="ni ni-fat-remove text-danger"></i></span>
</div>    