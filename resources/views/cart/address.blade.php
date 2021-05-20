Tempo Estimado de Entrega<span class="font-weight-light"></span>
<div class="card-content border-top">
    <br />
    @if($timeToPrepare != 0)
    {{$timeToPrepare}}min - {{$timeToPrepare*2}}min
    @else
    Não Informado
    @endif
</div>
<div class="mt-5">
    {{ 'Endereço de Entrega' }}<span class="font-weight-light"></span>
</div>
<div class="card-content border-top">
    <input type="hidden" value="{{$restorant->id}}" id="restaurant_id"/>
    <div class="form-group{{ $errors->has('addressID') ? ' has-danger' : '' }}">
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
            ?> value={{ $address->id }}>{{$address->nick." / ".$address->address}} </option>
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
        <button type="button" data-toggle="modal" data-target="#modal-order-new-address"  class="btn btn-success">Novo Endereço</button>
    </div>
    <div class="form-group">
    </div>
    <input type="hidden" name="deliveryCost" id="deliveryCost" value="0" />
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<!-- BS JavaScript -->

<!-- Have fun using Bootstrap JS -->
