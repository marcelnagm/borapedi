<div class="mt-5">
    <h5>{{ __('Restaurant information') }}<span class="font-weight-light"></span></h5>
</div>
<div class="card-content border-top">    
    <div class="pl-lg-4">
        <p>
            <img loading="lazy" src="/uploads/restorants/{{ $restorant->logo }}_thumbnail.jpg" ">
        <h6>{{ $restorant->name }}</h6>           
        </p>
        @if(!empty($openingTime) && !empty($closingTime))
        <p>{{ __('Today working hours') }}: {{ $openingTime . " - " . $closingTime }}</p>
        @endif
    </div>
</div>  