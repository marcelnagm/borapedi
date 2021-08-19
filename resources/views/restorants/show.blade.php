@extends('layouts.front', ['class' => ''])

@section('extrameta')
<title>{{ $restorant->name }}</title>
<meta property="og:image" content="{{ $restorant->logom }}">
    <meta property="og:image:type" content="image/png">
        <meta property="og:image:width" content="590">
            <meta property="og:image:height" content="400">
                <meta name="og:title" property="og:title" content="{{ $restorant->description }}">
                    <meta name="description" content="{{ $restorant->description }}">    
                        @endsection

                        @section('content')
                        <link href="/assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
                            <?php

                            function clean($string) {
                                $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

                                return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
                            }
                            ?>


                            <style>
                                .section-profile-cover{
                                    height: 250px !important;
                                }
                                .logo-img {
                                    width:120px!important;
                                    height:  120px!important;
                                    float:left;
                                }
                                .logo-text{
                                    float:left;
                                    height:  120px!important;
                                    padding: 4px;
                                    padding-top: 30px;
                                    padding-left: 30px;
                                    font-size: 24px;
                                }                                
                                .sub-description{
                                    margin-top: 140px;
                                    font-size: 20px;      
                                }

                                .text-icon-cart{                                        
                                    margin-left: 10px;
                                }
                                .btn-promotion{
                                    margin-top:0.5em;
                                    margin-right:0.5em;
                                    border-radius: 0.3em;
                                }
                                @media only screen and (max-width:1023px) {
                                    .logo-img {
                                        width: 60px !important;
                                        height:  60px!important;
                                        float:left;
                                    }
                                    .logo-text{
                                        float:left;
                                        width: 68vw !important;
                                        height:  13vh!important;
                                        padding: 2vw;
                                        font-size: 22px;
                                    }
                                    .sub-description{
                                        font-size: 1.2275rem;
                                        margin-top: 0px !important;
                                        font-weight: 600;
                                        line-height: 0.5
                                    }
                                    .text-icon-cart{
                                        display: none;
                                    }
                                }
                            </style>

                            @include('restorants.partials.modals')

                            <section class="section-profile-cover section-shaped grayscale-05 d-none d-md-none d-lg-block d-lx-block">
                                <!-- Circles background -->
                                <img class="bg-image" loading="lazy" src="{{ $restorant->coverm }}" style="width: 100%;">
                                    <!-- SVG separator -->
                                    <div class="separator separator-bottom separator-skew">
                                        <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
                                            <polygon class="fill-white" points="2560 0 2560 100 0 100"></polygon>
                                        </svg>
                                    </div>
                            </section>

                            <section class="section pt-lg-0 mb--5 mt--9 d-none d-md-none d-lg-block d-lx-block">
                                <div class="container">
                                    <div class="col-lg-12">
                                        <div class="title white"  <?php
                                        if ($restorant->description) {
                                            echo 'style="border-bottom: 1px solid #f2f2f2;"';
                                        }
                                        ?> >
                                            <h1 class="display-3 text-white" data-toggle="modal" data-target="#modal-restaurant-info" style="cursor: pointer;">
                                                <img loading="lazy" src="/uploads/restorants/{{ $restorant->logo }}_thumbnail.jpg" class="logo-img img-fluid rounded-circle shadow-lg" >            
                                                    <div class="logo-text">   {{ $restorant->name }} </div>
                                            </h1>
                                            </br>
                                            <p class="display-4 sub-description" >{{ $restorant->description }}</p>

                                            <p><i class="ni ni-watch-time"></i> @if(!empty($openingTime))<span class="closed_time">{{__('Opens')}} {{ $openingTime }}</span>@endif @if(!empty($closingTime))<span class="opened_time">{{__('Opened until')}} {{ $closingTime }}</span> @endif |   @if(!empty($restorant->address))<i class="ni ni-pin-3"></i></i> <a target="_blank" href="https://www.google.com/maps/search/?api=1&query={{ urlencode($restorant->address) }}">{{ $restorant->address }}</a>  | @endif @if(!empty($restorant->phone)) <i class="ni ni-mobile-button"></i> <a href="tel:{{$restorant->phone}}">{{ $restorant->phone }} </a> @endif @if(!empty($restorant->whatsapp_phone))  | <i class="fa fa-whatsapp "></i>Whatsapp
                                            <a  target="_blank" href="https://wa.me/{{ $restorant->getFormmatedWhatsapp() }}">{{ $restorant->whatsapp_phone }}</a>
                                                @endif
                                            </p>

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            @include('partials.flash')
                                        </div>
                                        @if (auth()->user()&&auth()->user()->hasRole('admin'))
                                        @include('restorants.admininfo')
                                        @endif
                                    </div>
                                </div>

                            </section>
                            <section class="section section-lg d-md-block d-lg-none d-lx-none" style="padding-bottom: 0px">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            @include('partials.flash')
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="title">
                                                <h1 class="display-3 text" data-toggle="modal" data-target="#modal-restaurant-info" style="cursor: pointer;">
                                                    <img loading="lazy" src="/uploads/restorants/{{ $restorant->logo }}_thumbnail.jpg" class="logo-img img-fluid rounded-circle shadow-lg" >            
                                                        <div class="logo-text">  {{ $restorant->name }}</div>
                                                </h1>
                                                <p class="display-4 text sub-description" >{{ $restorant->description }}</p>
                                                <p>
                                                    <i class="ni ni-watch-time"></i> @if(!empty($openingTime))<span class="closed_time">{{__('Opens')}} {{ $openingTime }}</span>@endif @if(!empty($closingTime))<span class="opened_time">{{__('Opened until')}} {{ $closingTime }}</span> @endif   
                                                    @if(!empty($restorant->address))<i class="ni ni-pin-3"></i></i> 
                                                    <a target="_blank" href="https://www.google.com/maps/search/?api=1&query={{ urlencode($restorant->address) }}">{{ $restorant->address }}</a>  |
                                                    @endif 
                                                    @if(!empty($restorant->phone)) 
                                                    <i class="ni ni-mobile-button"></i> <a href="tel:{{$restorant->phone}}">{{ $restorant->phone }} </a> 
                                                    @endif
                                                    @if(!empty($restorant->whatsapp_phone))  | <i class="fa fa-whatsapp "></i>Whatsapp
                                                    <a target="_blank" href="https://wa.me/{{ $restorant->whatsapp_phone }}">{{ $restorant->whatsapp_phone }}</a>
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            @include('restorants.partials.banners')
                            <section class="section pt-lg-0" id="restaurant-content" style="padding-top: 0px;z-index:100;">
                                <input type="hidden" id="rid" value="{{ $restorant->id }}"/>
                                <div class="container container-restorant">


                                    <?php $i = 0; ?>    
                                    @if(!$restorant->categories->isEmpty())
                                    <nav class="tabbable sticky" style="top: {{ config('app.isqrsaas') ? 64:88 }}px;">
                                        <ul class="nav nav-pills bg-white mb-2">                    

                                            @if(count($banners) > 0)
                                            <li  class="btn-promotion" >
                                                <a style="background-color: #ffa200 ;color:white;cursor:pointer;" class="nav-link  mb-sm-3 mb-md-0"  onclick="$('#modal-advertise').modal('show');">Promocões</a>
                                            </li>
                                            @endif
                                            @foreach ( $restorant->categories as $key => $category)
                                            @if(!$category->items->isEmpty())
                                            <li class="nav-item nav-item-category" id="{{ 'cat_'.clean(str_replace(' ', '', strtolower($category->name)).strval($key)) }}">
                                                <a class="nav-link mb-sm-3 mb-md-0 
                                                <?php
                                                if ($i == 0) {
                                                    ?> active<?php
                                                       $i++;
                                                       $aberto = clean(str_replace(' ', '', strtolower($category->name)) . strval($key));
                                                   }
                                                   ?>" data-toggle="tab" role="tab" id="{{ 'nav_'.clean(str_replace(' ', '', strtolower($category->name)).strval($key)) }}" href="#{{ clean(str_replace(' ', '', strtolower($category->name)).strval($key)) }}">{{ $category->name }}</a>
                                            </li>
                                            @endif
                                            @endforeach
                                            <li class="nav-item nav-item-category ">
                                                <a class="nav-link  mb-sm-3 mb-md-0" data-toggle="tab" role="tab" href="">{{ __('All categories') }}</a>
                                            </li>
                                        </ul>


                                    </nav>


                                    @endif



                                    @if(!$restorant->categories->isEmpty())
                                    @foreach ( $restorant->categories as $key => $category)
                                    @if(!$category->aitems->isEmpty())
                                    <div id="{{ clean(str_replace(' ', '', strtolower($category->name)).strval($key)) }}_titulo" class="{{ clean(str_replace(' ', '', strtolower($category->name)).strval($key)) }}"
                                         style="display:none;"        >                     
                                        <h1>{{ $category->name }}</h1><br />
                                    </div>
                                    @endif
                                    <div class="row {{ clean(str_replace(' ', '', strtolower($category->name)).strval($key)) }}" id="{{ clean(str_replace(' ', '', strtolower($category->name)).strval($key)) }}_box" style='display: none;'>                      

                                        @foreach ($category->aitems as $item)
                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                                            <div class="strip">
                                                @if(!empty($item->image))
                                                <figure>
                                                    <a onClick="setCurrentItem({{ $item->id }})" href="javascript:void(0)"><img src="{{ $item->logom }}" loading="lazy" data-src="{{ config('global.restorant_details_image') }}" class="img-fluid lazy" alt=""></a>
                                                </figure>
                                                @endif
                                                <span class="res_title"><b><a onClick="setCurrentItem({{ $item->id }})" href="javascript:void(0)">{{ $item->name }}</a></b></span><br />
                                                <span class="res_description">{{ $item->short_description}}</span><br />
                                                <span class="res_mimimum">@money($item->price, config('settings.cashier_currency'),config('settings.do_convertion'))</span>
                                            </div>
                                        </div>
                                        @endforeach                    
                                    </div>
                                    @endforeach
                                    @else
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                            <p class="text-muted mb-0">{{ __('Hmmm... Nothing found!')}}</p>
                                            <br/><br/><br/>
                                            <div class="text-center" style="opacity: 0.2;">
                                                <img src="https://www.jing.fm/clipimg/full/256-2560623_juice-clipart-pizza-box-pizza-box.png" width="200" height="200"></img>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    <!-- Check if is installed -->
                                    @if (isset($doWeHaveImpressumApp)&&$doWeHaveImpressumApp)

                                    <!-- Check if there is value -->
                                    @if (strlen($restorant->getConfig('impressum_value',''))>5)
                                    <h3>{{$restorant->getConfig('impressum_title','')}}</h3>
                                    <?php echo $restorant->getConfig('impressum_value', ''); ?>
                                    @endif
                                    @endif

                                </div>

                                @if(  !(isset($canDoOrdering)&&!$canDoOrdering)   )
                                <div class="callOutShoppingButtonBottom footerShow " >
                                    <div class="buttons_cart icon icon-shape text-white rounded-circle shadow mb-4 right" onClick="openNav()" >
                                        <i class="ni ni-cart"></i>
                                        <div class="text-icon-cart">
                                            Carrinho
                                        </div>
                                    </div>
                                    <div class="buttons_cart right icon icon-shape text-white rounded-circle shadow mb-4 ">                    

                                        <a class="text-white " href="{{route("cart.checkout")}}">
                                            <i class="ni ni-check-bold"></i>                            

                                        </a>
                                        <a class="text-white " href="{{route("cart.checkout")}}">
                                            <div class="text-icon-cart">
                                                Finalizar Pedido
                                            </div>
                                        </a>
                                    </div>
                                    <div class="buttons_cart right icon icon-shape text-white rounded-circle shadow mb-4 " onClick="share()">                    
                                        <i class="fa fa-share-alt"></i>
                                        <div class="text-icon-cart">
                                            Compartilhar
                                        </div>
                                    </div>
                                </div>
                                @endif

                            </section>
                            <div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
                                <div class="modal-dialog modal- modal-dialog-centered modal-sm" role="document">
                                    <div class="modal-content">
                                        <div class="modal-body p-0">
                                            <div class="card bg-secondary shadow border-0">
                                                <div class="card-header bg-transparent pb-2">
                                                    <h4 class="text-center mt-2 mb-3">{{ __('Call Waiter') }}</h4>
                                                </div>
                                                <div class="card-body px-lg-5 py-lg-5">
                                                    <form role="form" method="post" action="{{ route('call.waiter') }}">
                                                        @csrf
                                                        @include('partials.fields',$fields)
                                                        <div class="text-center">
                                                            <button type="submit" class="btn btn-primary my-4">{{ __('Call Now') }}</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endsection
                            @if ($showLanguagesSelector)
                            @section('addiitional_button_1')
                            <div class="dropdown web-menu">
                                <a href="#" class="btn btn-neutral dropdown-toggle " data-toggle="dropdown" id="navbarDropdownMenuLink2">
                                    <!--<img src="{{ asset('images') }}/icons/flags/{{ strtoupper(config('app.locale'))}}.png" /> --> {{ $currentLanguage }}
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="">
                                    @foreach ($restorant->localmenus()->get() as $language)
                                    @if ($language->language!=config('app.locale'))
                                    <li>
                                        <a class="dropdown-item" href="?lang={{ $language->language }}">
                                            <!-- <img src="{{ asset('images') }}/icons/flags/{{ strtoupper($language->language)}}.png" /> --> {{$language->languageName}}
                                        </a>
                                    </li>
                                    @endif
                                    @endforeach
                                </ul>
                            </div>
                            @endsection
                            @section('addiitional_button_1_mobile')
                            <div class="dropdown mobile_menu">

                                <a type="button" class="nav-link  dropdown-toggle" data-toggle="dropdown"id="navbarDropdownMenuLink2">
                                    <span class="btn-inner--icon">
                                        <i class="fa fa-globe"></i>
                                    </span>
                                    <span class="nav-link-inner--text">{{ $currentLanguage }}</span>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="">
                                    @foreach ($restorant->localmenus()->get() as $language)
                                    @if ($language->language!=config('app.locale'))
                                    <li>
                                        <a class="dropdown-item" href="?lang={{ $language->language }}">
                                           <!-- <img src="{{ asset('images') }}/icons/flags/{{ strtoupper($language->language)}}.png" /> ---> {{$language->languageName}}
                                        </a>
                                    </li>
                                    @endif
                                    @endforeach
                                </ul>
                            </div>
                            @endsection
                            @endif

                            @section('js')
                            <script>
                                var CASHIER_CURRENCY = "<?php echo config('settings.cashier_currency') ?>";
                                var LOCALE = "<?php echo App::getLocale() ?>";
                                var IS_POS = false;
                                @if (!$restorant->categories->isEmpty())

                                        $("#{{$aberto}}_titulo").show();
                                $("#{{$aberto}}_box").show();
                                @endif
                                        function share(){

                                        if (navigator.share) {
                                        navigator.share({
                                        title: document.title,
                                                text: "{{$restorant->name}}",
                                                url: window.location.href
                                        })
                                                .then(() => console.log('Successful share'))
                                                .catch(error => console.log('Error sharing:', error));
                                        }

                                        }


                                @if (count($banners) > 0)
                                        $(document).ready(function ($) {
                                $('#modal-advertise').modal('show');
                                });
                                @endif
                            </script>
                            <script src="{{ asset('custom') }}/js/order.js"></script>
                            @include('restorants.phporderinterface') 
                            @endsection
