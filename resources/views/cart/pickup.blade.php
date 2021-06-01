<div class="card-content col-12  row p-4" style="text-align: center;">        
    <div class="custom-control custom-radio mb-3 col-4">
        <input name="deliveryType" class="custom-control-input" id="deliveryTypePickup" type="radio" value="pickup">
        <label class="custom-control-label" for="deliveryTypePickup">{{ __('Pickup') }}</label>
    </div>

    @if(auth()->user()->plan()->count() !=  0)



    @if(auth()->user()->plan()->first()->local_table)
    <div class="custom-control custom-radio mb-3 col-4">
        <input name="deliveryType" class="custom-control-input" id="deliveryTypeDinein" type="radio" value="dinein" >
        <label class="custom-control-label" for="deliveryTypeDinein">Consumo no Local</label>
    </div>
    @endif
    @endif
</div>
