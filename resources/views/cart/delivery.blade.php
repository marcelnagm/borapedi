<div class="card card-profile shadow">
    <div class="px-4">
        <div class="mt-5">
            <h3>{{ __('Delivery / Pickup') }}<span class="font-weight-light"></span></h3>
        </div>
        <div class="card-content border-top">
            <br />
           @if($restorant->can_deliver == 1)
            <div class="custom-control custom-radio mb-3">
                <input name="deliveryType" class="custom-control-input" id="deliveryTypeDeliver" type="radio" value="delivery" checked>
                <label class="custom-control-label" for="deliveryTypeDeliver">{{ __('Delivery') }}</label>
            </div> 
            @endif
            @if($restorant->can_pickup == 1)
            <div class="custom-control custom-radio mb-3">
                <input name="deliveryType" class="custom-control-input" id="deliveryTypePickup" type="radio" value="pickup">
                <label class="custom-control-label" for="deliveryTypePickup">{{ __('Pickup') }}</label>
            </div>
            @endif
            @if($restorant->self_deliver == 1)
            <div class="custom-control custom-radio mb-3">
                <input name="deliveryType" class="custom-control-input" id="deliveryTypeDinein" type="radio" value="dinein" >
                <label class="custom-control-label" for="deliveryTypeDinein">Consumo no Local</label>
            </div>
            @endif

        </div>
        <br />
        <br />
    </div>
</div>
<br />
