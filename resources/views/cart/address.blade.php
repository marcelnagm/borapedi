<style>
    #addressID option{
        height: 24vh;
    }
    .select2-container .select2-selection--single .select2-selection__rendered{
        overflow: visible !important;
             text-overflow: visible !important; 
     white-space: normal !important; 

    }
    .select2-container{
           height: 18vh !important; 
    }
    
    .map_icon{
        width: 36px; 
        height: 41px;         
    }
    .select2-selection__clear{
        display: none;
        width: 36px; 
        height: 41px; 
        color: white !important;
        background-image: url('images/icons/address.png'); 
        display:block;
        left: 12px;
        cursor: none !important;
        position: relative !important;  
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow{
    display: none;
    }        
    
    .select2-selection__arrow   {
    -moz-appearance:none !important; /* Firefox */
    -webkit-appearance:none !important; /* Safari and Chrome */
    appearance:none !important`;
}
</style>
</br>
<div style="padding: 16px 16px 0 16px;">

    {{ 'Endereço de Entrega' }}<span class="font-weight-light"></span>
    <div class="card-content" >
    <input type="hidden" value="{{$restorant->id}}" id="restaurant_id"/>
    <div class="form-group{{ $errors->has('addressID') ? ' has-danger' : '' }}">
        <!--<img src="images/icons/map.png" class="map_icon">-->    
        @if(count($addresses))
        <select name="addressID" id="addressID" class="form-control{{ $errors->has('addressID') ? ' is-invalid' : '' }}  noselecttwo" required>
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
        @if ($errors->has('addressID'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('addressID') }}</strong>
        </span>
        @endif
        @else
        <h6 id="address-complete-order">{{ __('You don`t have any address. Please add new one') }}.</h6>
        @endif
        <div class=" text-center">
        <button type="button" data-toggle="modal" data-target="#modal-order-new-address"  class="btn btn-success">Novo Endereço</button>    
        </div>
        
    </div>
    <div class="form-group">
    </div>
    <input type="hidden" name="deliveryCost" id="deliveryCost" value="0" />
</div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<!-- BS JavaScript -->

<!-- Have fun using Bootstrap JS -->