<div class="card-content border-top">    
    <div class="pl-lg-4">
        <p>
            <font >{{$restorant->name }} 
            </br>
            @if(!empty($openingTime) && !empty($closingTime))
                {{ __('Today working hours') }}: {{ $openingTime . " - " . $closingTime }}</p>
            @endif
            </font>
            <img loading="lazy" src="/uploads/restorants/{{ $restorant->logo }}_thumbnail.jpg" >            
    </p>
    </div>
</div>  