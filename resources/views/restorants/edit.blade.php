@extends('layouts.app', ['title' => __('Orders')])
@section('admin_title')
    {{__('Restaurant Management')}}
@endsection
@section('content')
<div class="header bg-gradient-info pb-6 pt-5 pt-md-8">
    <div class="container-fluid">

        <div class="nav-wrapper">
            <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="res_menagment" role="tablist">

                <li class="nav-item">
                    <a class="nav-link mb-sm-3 mb-md-0 active " id="tabs-menagment-main" data-toggle="tab" href="#menagment" role="tab" aria-controls="tabs-menagment" aria-selected="true"><i class="ni ni-badge mr-2"></i>{{ __('Restaurant Management')}}</a>
                </li>

                    <li class="nav-item">
                        <a class="nav-link mb-sm-3 mb-md-0 " id="tabs-menagment-main" data-toggle="tab" href="#apps" role="tab" aria-controls="tabs-menagment" aria-selected="true"><i class="ni ni-spaceship mr-2"></i>{{ __('Apps')}}</a>
                    </li>
                

                <li class="nav-item">
                    <a class="nav-link mb-sm-3 mb-md-0 " id="tabs-menagment-main" data-toggle="tab" href="#location" role="tab" aria-controls="tabs-menagment" aria-selected="true"><i class="ni ni-square-pin mr-2"></i>{{ __('Location')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mb-sm-3 mb-md-0" id="tabs-menagment-main" data-toggle="tab" href="#hours" role="tab" aria-controls="tabs-menagment" aria-selected="true"><i class="ni ni-time-alarm mr-2"></i>{{ __('Working Hours')}}</a>
                </li>
                
                @if(auth()->user()->hasRole('admin'))
                    <li class="nav-item">
                        <a class="nav-link mb-sm-3 mb-md-0" id="tabs-menagment-main" data-toggle="tab" href="#plan" role="tab" aria-controls="tabs-menagment" aria-selected="true"><i class="ni ni-money-coins mr-2"></i>{{ __('Plans')}}</a>
                    </li>
                @endif
            </ul>
        </div>

    </div>
</div>



<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-12">
            <br />

            @include('partials.flash')

            <div class="tab-content" id="tabs">


                <!-- Tab Managment -->
                <div class="tab-pane fade show active" id="menagment" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                    <div class="card bg-secondary shadow">
                        <div class="card-header bg-white border-0">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h3 class="mb-0">{{ __('Restaurant Management') }}</h3>
                                    @if (config('settings.wildcard_domain_ready'))
                                    <span class="blockquote-footer">{{ $restorant->getLinkAttribute() }}</span>
                                    @endif
                                </div>
                                <div class="col-4 text-right">
                                    @if(auth()->user()->hasRole('admin'))
                                    <a href="{{ route('admin.restaurants.index') }}"
                                        class="btn btn-sm btn-info">{{ __('Back to list') }}</a>
                                    @endif
                                    @if (config('settings.wildcard_domain_ready'))
                                    <a target="_blank" href="{{ $restorant->getLinkAttribute() }}"
                                        class="btn btn-sm btn-success">{{ __('View it') }}</a>
                                    @else
                                    @if ($restorant->subdomain != "")
                                    <a target="_blank" href="{{ route('vendor',$restorant->subdomain) }}"
                                        class="btn btn-sm btn-success">{{ __('View it') }}</a>
                                    @endif
                                    @endif

                                </div>

                            </div>
                        </div>
                        <div class="card-body">
                            <h6 class="heading-small text-muted mb-4">{{ __('Restaurant information') }}</h6>
                            
                            @include('restorants.partials.info')
                            <hr />
                            @include('restorants.partials.owner')
                        </div>
                    </div>
                </div>

                <!-- Tab Apps -->
                    <div class="tab-pane fade show" id="apps" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                        @include('restorants.partials.apps') 
                    </div>

                <!-- Tab Location -->
                <div class="tab-pane fade show" id="location" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                    @include('restorants.partials.location')
                </div>

                <!-- Tab Hours -->
                <div class="tab-pane fade show" id="hours" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                    @include('restorants.partials.hours')
                </div>

                <!-- Tab Hours -->
                @if(auth()->user()->hasRole('admin'))
                    <div class="tab-pane fade show" id="plan" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                        @include('restorants.partials.plan')
                    </div>
                @endif

            </div>
        </div>
    </div>
    @include('layouts.footers.auth')
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>

<script>
 $("#phone").mask("(00) 00000-0000");
 $("#whatsapp_phone").mask("(00) 00000-0000");
</script>
@endsection


@section('js')
<!-- Google Map -->
<script type="text/javascript" src="http://maps.google.com/maps/api/js?key=<?php echo config('settings.google_maps_api_key'); ?>"></script>


    <script type="text/javascript">
        "use strict";
        $('.select2').css('width','50% !important');

        var defaultHourFrom = "09:00";
        var defaultHourTo = "17:00";

        var timeFormat = '{{ config('settings.time_format') }}';

        function formatAMPM(date) {
            //var hours = date.getHours();
            //var minutes = date.getMinutes();
            var hours = date.split(':')[0];
            var minutes = date.split(':')[1];

            var ampm = hours >= 12 ? 'pm' : 'am';
            hours = hours % 12;
            hours = hours ? hours : 12; // the hour '0' should be '12'
            //minutes = minutes < 10 ? '0'+minutes : minutes;
            var strTime = hours + ':' + minutes + ' ' + ampm;
            return strTime;
        }

        //console.log(formatAMPM("19:05"));
        
  
        var config = {
            enableTime: true,
            dateFormat: timeFormat == "AM/PM" ? "h:i K": "H:i",
            noCalendar: true,
            altFormat: timeFormat == "AM/PM" ? "h:i K" : "H:i",
            altInput: true,
            allowInput: true,
            time_24hr: timeFormat == "AM/PM" ? false : true,
            onChange: [
                function(selectedDates, dateStr, instance){
                    //...
                    this._selDateStr = dateStr;
                },
            ],
            onClose: [
                function(selDates, dateStr, instance){
                    if (this.config.allowInput && this._input.value && this._input.value !== this._selDateStr) {
                        this.setDate(this.altInput.value, false);
                    }
                }
            ]
        };

        $("input[type='checkbox'][name='days']").change(function() {
            //console.log($('#'+ this.id).attr("valuetwo"))
            var hourFrom = flatpickr($('#'+ this.value + '_from'+"_shift"+$('#'+ this.id).attr("valuetwo")), config);
            var hourTo = flatpickr($('#'+ this.value + '_to'+"_shift"+$('#'+ this.id).attr("valuetwo")), config);

            if(this.checked){
                hourFrom.setDate(timeFormat == "AP/PM" ? formatAMPM(defaultHourFrom) : defaultHourFrom, false);
                hourTo.setDate(timeFormat == "AP/PM" ? formatAMPM(defaultHourTo) : defaultHourTo, false);
            }else{
                hourFrom.clear();
                hourTo.clear();
            }
        });

        //Initialize working hours
        function initializeWorkingHours(){
            var shifts = {!! json_encode($shifts) !!};
            
            if(shifts != null){
                Object.keys(shifts).map((shiftKey)=>{
                    var sk=shiftKey;
                    var workingHours=shifts[shiftKey];
                    console.log(workingHours);
                    Object.keys(workingHours).map((key, index)=>{
                        //now we have the shifts
                        if(workingHours[key] != null){
                            
                            var hour = flatpickr($('#'+key+'_shift'+shiftKey), config);
                            hour.setDate(workingHours[key], false);

                            var day_key = key.split('_')[0];
                            $('#day'+day_key+'_shift'+shiftKey).attr('checked', 'checked');
                        }
                    });
                    

                })
            }
        }
        
          
        window.onload = function () {
            //var map, infoWindow, marker, lng, lat;

            //Working hours
            initializeWorkingHours();
            drawmap();
          
        }

    </script>
@endsection
