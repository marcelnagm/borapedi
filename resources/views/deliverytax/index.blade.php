@extends('layouts.app', ['title' => __('Orders')])
@section('admin_title')
{{ config('settings.url_route')." ".__('Management')}}
@endsection
@section('content')
<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
</div>
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-12">
            <br/>
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">{{ __('Delivery tax')}}</h3>
                            @include('deliverytax.form')    
                        </div>                       
                    </div>
                </div>
                <div class="card-body">
                    <h6 class="heading-small text-muted mb-4">{{ __('Delivery tax list') }}</h6>
                    <hr />
                    
                    <div class="table-responsive">
                        <table class="table align-items-center" id='result'>                           
                            @include('deliverytax.list')                            
                        </table>
                    </div>'
                  
                </div>
            </div>
        </div>
        <div class="card bg-secondary shadow col-12" style="margin-top: 1vh;">
             <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                            <h5 class="mb-0"> Áreas Atendidas</h5>
                    </div>
                </div>
              <div id="map_canvas" style="height: 60vh; width:45vw">
                        
                    </div>


        </div>
    </div>
    @include('layouts.footers.auth')
</div>
@endsection

@section('js')



<!-- Google Map -->
<!--<script async defer src= "https://maps.googleapis.com/maps/api/js?libraries=geometry,drawing&key=<?php // echo config('settings.google_maps_api_key'); ?>"></script>-->

<script type="text/javascript" src="http://maps.google.com/maps/api/js?key=<?php echo config('settings.google_maps_api_key'); ?>"></script>
<script type="text/javascript">
  
  var lat = <?php echo $lat ?>;
  var lng = <?php echo $lng ?>;
  
  $(document).ready(function() {
      drawmap();
});
  
    //console.log(formatAMPM("19:05"));
    var form = document.getElementById('restorant-form');
    form.addEventListener('submit', async function (event) {
        event.preventDefault();
//        alert('exectuado');
        var distance = $('#distance').val();
        var cost = $('#cost').val();
        var restaurant_id = $('#rid').val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: 'POST',
            url: '/deliverytax/post',
//            dataType: 'json',
            data: {distance: distance,
                cost: cost,
                restaurant_id: restaurant_id 
            },
            success: function (response) { 
//                alert('sucess');
                console.log(response.text);
                    $("#result").html(response); 
                    $('#distance').val('');
                    $('#cost').val('');   
                    $("#map_canvas").html();
                drawmap();
            }, error: function (response) {
                //alert(response.responseJSON.errMsg);
            }
        })
    });      
    
</script>
@endsection

