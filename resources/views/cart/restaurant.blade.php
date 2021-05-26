<div class="" style="float: left; padding: 10 0 10 0; width: 100% ">
    <img loading="lazy" src="/uploads/restorants/{{ $restorant->logo }}_thumbnail.jpg" class="logo-img img-fluid rounded-circle shadow-lg" >            
    <div class="logo-text"> 
        {{ $restorant->name }}                            
        <p>
            @if(!empty($openingTime) && !empty($closingTime))
            {{ __('Today working hours') }}: {{ $openingTime . " - " . $closingTime }}</p>
        @endif
        
        </p>
    </div>
</div>