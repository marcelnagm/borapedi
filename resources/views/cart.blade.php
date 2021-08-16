@extends('layouts.front', ['class' => ''])
@section('content')

<script src="{{ asset('social') }}/js/core/jquery.min.js" type="text/javascript"></script>
<script src="{{ asset('custom') }}/js/notify.min.js"></script>

<section class="section-profile-cover section-shaped my--1 d-none d-md-none d-lg-block d-lx-block">
    <!-- Circles background -->
    <img class="bg-image " src="{{ config('global.restorant_details_cover_image') }}" style="width: 100%;">
    <!-- SVG separator -->
    <div class="separator separator-bottom separator-skew">

    </div>
</section>
<style>
    .cart_adapt {
        margin-top: -450px!important;
    }
    .logo-img {
        width: 60px !important;
        height:  60px!important;
        float:left;
        margin-left: 10px;
    }
    .logo-text{
        float:left;
        width: 35vw !important;
        height:  15vh!important;
        padding: 2.4vw;
        font-size: 18px;
    }

    .nav-delivery{
        border: black solid 1px;
    }
    .nav-pickup{
        border-right:  black solid 1px;
        border-top:  black solid 1px;
        border-bottom:   black solid 1px;
    }
    .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
        background: #ffe7bd;
    }

    @media only screen and (max-width:1023px) {
        .cart_adapt{
            margin-top: 0!important;
        }
        .padding-left{
            padding-left: 5px;
        }

        .logo-img {
            width: 40px !important;
            height:  40px!important;
            float:left;
        }
        .logo-text{
            float:left;
            width: 53vw !important;
            height:  7vh!important;
            padding: 2.0vw;
            font-size: 16px;
        }
        .col-12-ml{
            flex: 0 0 100% !important;
            max-width: 100% !important;
        }
    }


</style>
<section class="section bg-secondary">

    <div class="container">       

        <div class="row">

            <!-- Left part -->
            <div class="col-7 col-12-ml">                
                <div class="card card-profile shadow cart_adapt">
                    <div class="row">
                        <div class="col">
                            <a 
                                href="{{route('vendor',['alias'=>$restorant->alias])}}"">
                                <i class="fa fa-chevron-left fa-2x left" aria-hidden="true"></i>

                            </a>
                        </div>
                        <div class="col ">
                            <div class="right">
                                <a 
                                    href="{{ route('cart.clear') }}"">
                                    Limpar

                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="nav-wrapper">
                        <ul class="nav nav-tabs nav-fill" id="res_menagment" role="tablist">

                            <li class="nav-item nav-delivery text-white btn-neutral">
                                <a class="nav-link mb-sm-3 mb-md-0  active " id="tabs-menagment-main" data-toggle="tab" href="#delivery" role="tab" aria-controls="tabs-menagment" aria-selected="true"><i class="ni ni-badge mr-2"></i>Entregar</a>
                            </li>
                            <li class="nav-item nav-pickup text-white btn-neutral">
                                <a class="nav-link mb-sm-3 mb-md-0 " id="tabs-menagment-main" data-toggle="tab" href="#pickup" role="tab" aria-controls="tabs-menagment" aria-selected="true"><i class="ni ni-square-pin mr-2"></i>Buscar</a>
                            </li>                            
                        </ul>
                    </div>

                    <form id="order-form" role="form" method="post" action="{{route('order.store')}}" autocomplete="off" enctype="multipart/form-data">
                        <input type="submit" value="Click me" style="display:none;" />
                        @csrf

                        <div class="tab-content" id="tabs">


                            @if($restorant->can_deliver == 1 )

                            <div class="tab-pane fade show active" id="delivery" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                                @include('cart.tete')

                                <div id='addressBox'>
                                    @include('cart.address')
                                </div>                                 
                            </div>
                            @endif                       
                            @if(($restorant->can_pickup == 1) || ($restorant->can_deliver == 1))
                            <div class="tab-pane fade show" id="pickup" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                                @include('cart.pickup')

                                <div class="takeaway_picker" style="display: none">
                                    <!-- LOCAL ORDERING -->
                                    @include('cart.localorder.table')
                                </div>
                            </div>
                            @endif 
                        </div>



                        <?php if (auth()->user()->phone == "") { ?>
                            @include('cart.phone_modal')
                        <?php } ?>
                        <!-- Delivery address -->

                        <!--@include('cart.restaurant')-->
                        <!-- List of items -->
                        @include('cart.restaurant')
                        @include('cart.items')


                        @include('cart.comment')

                        @if(count($timeSlots)>0)
                        <!-- Delivery method -->                     
                        @include('cart.time')
                        <!-- Comment -->
                        @endif

                        <!-- Restaurant -->

                </div>
            </div>


            <!-- Right Part -->
            <div class="col-md-5">

                @if (count($timeSlots)>0)
                <!-- Payment -->
                @include('cart.payment')

                <br/>


                @else
                <!-- Closed restaurant -->
                @include('cart.closed')
                @endif


            </div>
        </div>
    </div>
    <div class="callOutShoppingButtonBottom footerShow " style="background-color: revert !important
         " >

        @include('cart.payments.whatsapp')

    </div>

    @include('cart.money_modal')
    @include('clients.modals')
</form>
                    
    <?php if (auth()->user()->name == "") { ?>
        @include('cart.complete_all_modal')
        <?php } ?>
</section>
@endsection
@section('js')

<script async defer src= "https://maps.googleapis.com/maps/api/js?key=<?php echo config('settings.google_maps_api_key'); ?>&callback=initAddressMap"></script>
<!-- Stripe -->
<script src="https://js.stripe.com/v3/"></script>
<script>
"use strict";
var num_addresses = {{count($addresses) }};
$(document).ready(function ($) {
<?php if (count($addresses) == 0) { ?>
    $('#modal-order-new-address').modal('show');
<?php } ?>
    <?php if (auth()->user()->name == "") { ?>
        $('#modal-order-complete').modal('show');
        <?php } ?>
});
var RESTORANT = <?php echo json_encode($restorant) ?>;
var STRIPE_KEY = "{{ config('settings.stripe_key') }}";
var ENABLE_STRIPE = false;
var initialOrderType = 'delivery';
if (RESTORANT.can_deliver == 1 && RESTORANT.can_pickup == 0) {
initialOrderType = 'delivery';
} else if (RESTORANT.can_deliver == 0 && RESTORANT.can_pickup == 1) {
initialOrderType = 'pickup';
}
$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
var target = $(e.target).attr("href") // activated tab
//        alert(target);
        if (target == "#delivery")
        {
        $("input[value='delivery']").attr('checked', true);
        $("#addressBox").show(1);
        $("input[value='pickup']").attr('checked', false);
        $("input[value='dinein']").attr('checked', false);
        }
if (target == "#pickup")
        {

        $("input[value='delivery']").attr('checked', false);
        $("input[value='pickup']").attr('checked', true);
        $("input[value='dinein']").attr('checked', false);
        }
});</script>
<script src="{{ asset('custom') }}/js/checkout.js"></script>
@endsection

