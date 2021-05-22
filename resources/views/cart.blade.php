@extends('layouts.front', ['class' => ''])
@section('content')
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
        width: 11vw !important;
        height:  19vh!important;
        float:left;
    }
    .logo-text{
        float:left;
        width: 35vw !important;
        height:  19vh!important;
        padding: 2.4vw;
        font-size: 6vh;
    }

    @media only screen and (max-width:1023px) {
        .cart_adapt{
            margin-top: 0!important;
        }
        .padding-left{
            padding-left: 5px;
        }

        .logo-img {
            width: 24vw !important;
            height:  13vh!important;
            float:left;
        }
        .logo-text{
            float:left;
            width: 53vw !important;
            height:  13vh!important;
            padding: 2.0vw;
            font-size: 6vw;
        }
        .col-12-ml{
            flex: 0 0 100% !important;
            max-width: 100% !important;
        }
    }


</style>
<section class="section bg-secondary">

    <div class="container">


        <x:notify-messages />

        <div class="row">

            <!-- Left part -->
            <div class="col-7 col-12-ml">                
                <div class="card card-profile shadow cart_adapt">
                    

                    <form id="order-form" role="form" method="post" action="{{route('order.store')}}" autocomplete="off" enctype="multipart/form-data">
                        @csrf
                        @if(($restorant->can_pickup == 1) || ($restorant->can_deliver == 1) || ($restorant->self_deliver == 1) )

                        @include('cart.restaurant')
                        @include('cart.delivery')

                        @endif                       
                        <?php if (auth()->user()->phone == "") { ?>
                            @include('cart.phone_modal')
                        <?php } ?>
                        <!-- Delivery address -->
                        <div id='addressBox'>
                            @include('cart.address')
                        </div>                        
                        <div class="takeaway_picker" style="display: none">
                            <!-- LOCAL ORDERING -->
                            @include('cart.localorder.table')
                        </div>
                        <!--@include('cart.restaurant')-->
                        <!-- List of items -->
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
                <!--
                  <br/>
                  @include('cart.coupons')
                -->
                @else
                <!-- Closed restaurant -->
                @include('cart.closed')
                @endif


            </div>
        </div>


    </div>
    @include('clients.modals')
</section>
@endsection
@section('js')

<script async defer src= "https://maps.googleapis.com/maps/api/js?key=<?php echo config('settings.google_maps_api_key'); ?>&callback=initAddressMap"></script>
<!-- Stripe -->
<script src="https://js.stripe.com/v3/"></script>
<script>
"use strict";
var num_addresses = {{count($addresses) }};
<?php if (count($addresses) == 0) { ?>

    $(document).ready(function ($) {
    $('#modal-order-new-address').modal('show');
    });
<?php } ?>

var RESTORANT = <?php echo json_encode($restorant) ?>;
var STRIPE_KEY = "{{ config('settings.stripe_key') }}";
var ENABLE_STRIPE = "{{ config('settings.enable_stripe') }}";
var initialOrderType = 'delivery';
if (RESTORANT.can_deliver == 1 && RESTORANT.can_pickup == 0) {
initialOrderType = 'delivery';
} else if (RESTORANT.can_deliver == 0 && RESTORANT.can_pickup == 1) {
initialOrderType = 'pickup';
}
</script>
<script src="{{ asset('custom') }}/js/checkout.js"></script>
@endsection

