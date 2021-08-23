<div style="padding: 0 20px 0 20px;">
@if(count($addresses))
        <select name="addressID" id="addressID" class="noselecttwo {{ $errors->has('addressID') ? ' is-invalid' : '' }}" required>
            <option  disabled value> {{__('-- select an option -- ')}}</option>
            @foreach ($addresses as $key => $address)
            @if(config('settings.enable_cost_per_distance'))
            <option data-cost={{ $address->cost_per_km}} id="{{ 'address'.$address->id }}"  <?php
                if (!$address->inRadius) {
                    echo "disabled";
                }
                ?> value={{ $address->id }}>{{$address->address." - ".money( $address->cost_per_km, config('settings.cashier_currency'),config('settings.do_convertion')) }} </option>
            @else
            <option data-cost="{{$address->cost_total}}" id="{{ 'address'.$address->id }}"  <?php
            if (!$address->inRadius) {
                echo "disabled";
            }
            ?> value={{ $address->id }}>Entregar em {{$address->nick}}{{"\n"}}
            {{$address->address}} </option>
            @endif
            @endforeach
        </select>
        @else
        <h6 id="address-complete-order">{{ __('You don`t have any address. Please add new one') }}.</h6>
        @endif
        <div class=" text-center" style="s">
        <button type="button" data-toggle="modal" data-target="#modal-order-new-address"  class="btn btn-danger my-4">Novo Endereço</button>    
        </div>        
    <input type="hidden" name="deliveryCost" id="deliveryCost" value="0" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<!-- BS JavaScript -->
</div>
<!-- Have fun using Bootstrap JS -->