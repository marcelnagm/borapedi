<?php $__env->startSection('extrameta'); ?>
<title><?php echo e($restorant->name); ?></title>
<meta property="og:image" content="<?php echo e($restorant->logom); ?>">
    <meta property="og:image:type" content="image/png">
        <meta property="og:image:width" content="590">
            <meta property="og:image:height" content="400">
                <meta name="og:title" property="og:title" content="<?php echo e($restorant->description); ?>">
                    <meta name="description" content="<?php echo e($restorant->description); ?>">    
                        <?php $__env->stopSection(); ?>

                        <?php $__env->startSection('content'); ?>
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
                                @media  only screen and (max-width:1023px) {
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

                            <?php echo $__env->make('restorants.partials.modals', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                            <section class="section-profile-cover section-shaped grayscale-05 d-none d-md-none d-lg-block d-lx-block">
                                <!-- Circles background -->
                                <img class="bg-image" loading="lazy" src="<?php echo e($restorant->coverm); ?>" style="width: 100%;">
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
                                                <img loading="lazy" src="/uploads/restorants/<?php echo e($restorant->logo); ?>_thumbnail.jpg" class="logo-img img-fluid rounded-circle shadow-lg" >            
                                                    <div class="logo-text">   <?php echo e($restorant->name); ?> </div>
                                            </h1>
                                            </br>
                                            <p class="display-4 sub-description" ><?php echo e($restorant->description); ?></p>

                                            <p><i class="ni ni-watch-time"></i> <?php if(!empty($openingTime)): ?><span class="closed_time"><?php echo e(__('Opens')); ?> <?php echo e($openingTime); ?></span><?php endif; ?> <?php if(!empty($closingTime)): ?><span class="opened_time"><?php echo e(__('Opened until')); ?> <?php echo e($closingTime); ?></span> <?php endif; ?> |   <?php if(!empty($restorant->address)): ?><i class="ni ni-pin-3"></i></i> <a target="_blank" href="https://www.google.com/maps/search/?api=1&query=<?php echo e(urlencode($restorant->address)); ?>"><?php echo e($restorant->address); ?></a>  | <?php endif; ?> <?php if(!empty($restorant->phone)): ?> <i class="ni ni-mobile-button"></i> <a href="tel:<?php echo e($restorant->phone); ?>"><?php echo e($restorant->phone); ?> </a> <?php endif; ?> 
                                            <?php if(!empty($restorant->whatsapp_phone)): ?>  | <i class="fa fa-whatsapp "></i>Whatsapp
                                            <a  target="_blank" href="https://wa.me/<?php echo e($restorant->getFormmatedWhatsapp()); ?>"><?php echo e($restorant->whatsapp_phone); ?></a>
                                                <?php endif; ?>
                                                
                                                    <?php if($restorant->fidelity_program() != null): ?> 
                                                    |<a data-toggle="modal" data-target="#modal-restaurant-info" style="cursor: pointer;" >
                                                        <i style="color:gold;"  class="ni ni-trophy"></i>
                                                        Programa de Fidelidade
                                                    </a>
                                                    <?php endif; ?>
                                            </p>

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <?php echo $__env->make('partials.flash', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        </div>
                                        <?php if(auth()->user()&&auth()->user()->hasRole('admin')): ?>
                                        <?php echo $__env->make('restorants.admininfo', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        <?php endif; ?>
                                    </div>
                                </div>

                            </section>
                            <section class="section section-lg d-md-block d-lg-none d-lx-none" style="padding-bottom: 0px">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <?php echo $__env->make('partials.flash', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="title">
                                                <h1 class="display-3 text" data-toggle="modal" data-target="#modal-restaurant-info" style="cursor: pointer;">
                                                    <img loading="lazy" src="/uploads/restorants/<?php echo e($restorant->logo); ?>_thumbnail.jpg" class="logo-img img-fluid rounded-circle shadow-lg" >            
                                                        <div class="logo-text">  <?php echo e($restorant->name); ?></div>
                                                </h1>
                                                <p class="display-4 text sub-description" ><?php echo e($restorant->description); ?></p>
                                                <p>
                                                    <i class="ni ni-watch-time"></i> <?php if(!empty($openingTime)): ?><span class="closed_time"><?php echo e(__('Opens')); ?> <?php echo e($openingTime); ?></span><?php endif; ?> <?php if(!empty($closingTime)): ?><span class="opened_time"><?php echo e(__('Opened until')); ?> <?php echo e($closingTime); ?></span> <?php endif; ?>   
                                                    <?php if(!empty($restorant->address)): ?><i class="ni ni-pin-3"></i></i> 
                                                    <a target="_blank" href="https://www.google.com/maps/search/?api=1&query=<?php echo e(urlencode($restorant->address)); ?>"><?php echo e($restorant->address); ?></a>  |
                                                    <?php endif; ?> 
                                                    <?php if(!empty($restorant->phone)): ?> 
                                                    <i class="ni ni-mobile-button"></i> <a href="tel:<?php echo e($restorant->phone); ?>"><?php echo e($restorant->phone); ?> </a> 
                                                    <?php endif; ?>
                                                    <?php if(!empty($restorant->whatsapp_phone)): ?>  | <i class="fa fa-whatsapp "></i>Whatsapp
                                                    <a target="_blank" href="https://wa.me/<?php echo e($restorant->whatsapp_phone); ?>"><?php echo e($restorant->whatsapp_phone); ?></a>
                                                    <?php endif; ?>
                                                    <?php if($restorant->fidelity_program() != null): ?> 
                                                    <a target="_blank" href="https://wa.me/">Programa de Fidelidade</a>
                                                    <?php endif; ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <?php echo $__env->make('restorants.partials.banners', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <section class="section pt-lg-0" id="restaurant-content" style="padding-top: 0px;z-index:100;">
                                <input type="hidden" id="rid" value="<?php echo e($restorant->id); ?>"/>
                                <div class="container container-restorant">


                                    <?php $i = 0; ?>    
                                    <?php if(!$restorant->categories->isEmpty()): ?>
                                    <nav class="tabbable sticky" style="top: <?php echo e(config('app.isqrsaas') ? 64:88); ?>px;">
                                        <ul class="nav nav-pills bg-white mb-2">                    

                                            <?php if(count($banners) > 0): ?>
                                            <li  class="btn-promotion" >
                                                <a style="background-color: #ffa200 ;color:white;cursor:pointer;" class="nav-link  mb-sm-3 mb-md-0"  onclick="$('#modal-advertise').modal('show');">Promocões</a>
                                            </li>
                                            <?php endif; ?>
                                            <?php $__currentLoopData = $restorant->categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if(!$category->items->isEmpty()): ?>
                                            <li class="nav-item nav-item-category" id="<?php echo e('cat_'.clean(str_replace(' ', '', strtolower($category->name)).strval($key))); ?>">
                                                <a class="nav-link mb-sm-3 mb-md-0 
                                                <?php
                                                if ($i == 0) {
                                                    ?> active<?php
                                                       $i++;
                                                       $aberto = clean(str_replace(' ', '', strtolower($category->name)) . strval($key));
                                                   }
                                                   ?>" data-toggle="tab" role="tab" id="<?php echo e('nav_'.clean(str_replace(' ', '', strtolower($category->name)).strval($key))); ?>" href="#<?php echo e(clean(str_replace(' ', '', strtolower($category->name)).strval($key))); ?>"><?php echo e($category->name); ?></a>
                                            </li>
                                            <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <li class="nav-item nav-item-category ">
                                                <a class="nav-link  mb-sm-3 mb-md-0" data-toggle="tab" role="tab" href=""><?php echo e(__('All categories')); ?></a>
                                            </li>
                                        </ul>


                                    </nav>


                                    <?php endif; ?>



                                    <?php if(!$restorant->categories->isEmpty()): ?>
                                    <?php $__currentLoopData = $restorant->categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if(!$category->aitems->isEmpty()): ?>
                                    <div id="<?php echo e(clean(str_replace(' ', '', strtolower($category->name)).strval($key))); ?>_titulo" class="<?php echo e(clean(str_replace(' ', '', strtolower($category->name)).strval($key))); ?>"
                                         style="display:none;"        >                     
                                        <h1><?php echo e($category->name); ?></h1><br />
                                    </div>
                                    <?php endif; ?>
                                    <div class="row <?php echo e(clean(str_replace(' ', '', strtolower($category->name)).strval($key))); ?>" id="<?php echo e(clean(str_replace(' ', '', strtolower($category->name)).strval($key))); ?>_box" style='display: none;'>                      

                                        <?php $__currentLoopData = $category->aitems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                                            <div class="strip">
                                                <?php if(!empty($item->image)): ?>
                                                <figure>
                                                    <a onClick="setCurrentItem(<?php echo e($item->id); ?>)" href="javascript:void(0)"><img src="<?php echo e($item->logom); ?>" loading="lazy" data-src="<?php echo e(config('global.restorant_details_image')); ?>" class="img-fluid lazy" alt=""></a>
                                                </figure>
                                                <?php endif; ?>
                                                <span class="res_title"><b><a onClick="setCurrentItem(<?php echo e($item->id); ?>)" href="javascript:void(0)"><?php echo e($item->name); ?></a></b></span><br />
                                                <span class="res_description"><?php echo e($item->short_description); ?></span><br />
                                                <span class="res_mimimum"><?php echo money($item->price, config('settings.cashier_currency'),config('settings.do_convertion')); ?></span>
                                            </div>
                                        </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                    
                                    </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                            <p class="text-muted mb-0"><?php echo e(__('Hmmm... Nothing found!')); ?></p>
                                            <br/><br/><br/>
                                            <div class="text-center" style="opacity: 0.2;">
                                                <img src="https://www.jing.fm/clipimg/full/256-2560623_juice-clipart-pizza-box-pizza-box.png" width="200" height="200"></img>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    <!-- Check if is installed -->
                                    <?php if(isset($doWeHaveImpressumApp)&&$doWeHaveImpressumApp): ?>

                                    <!-- Check if there is value -->
                                    <?php if(strlen($restorant->getConfig('impressum_value',''))>5): ?>
                                    <h3><?php echo e($restorant->getConfig('impressum_title','')); ?></h3>
                                    <?php echo $restorant->getConfig('impressum_value', ''); ?>
                                    <?php endif; ?>
                                    <?php endif; ?>

                                </div>

                                <?php if(  !(isset($canDoOrdering)&&!$canDoOrdering)   ): ?>
                                <div class="callOutShoppingButtonBottom footerShow " >
                                    <div class="buttons_cart icon icon-shape text-white rounded-circle shadow mb-4 right" onClick="openNav()" >
                                        <i class="ni ni-cart"></i>
                                        <div class="text-icon-cart">
                                            Carrinho
                                        </div>
                                    </div>
                                    <div class="buttons_cart right icon icon-shape text-white rounded-circle shadow mb-4 ">                    

                                        <a class="text-white " href="<?php echo e(route("cart.checkout")); ?>">
                                            <i class="ni ni-check-bold"></i>                            

                                        </a>
                                        <a class="text-white " href="<?php echo e(route("cart.checkout")); ?>">
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
                                <?php endif; ?>

                            </section>
                            <div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
                                <div class="modal-dialog modal- modal-dialog-centered modal-sm" role="document">
                                    <div class="modal-content">
                                        <div class="modal-body p-0">
                                            <div class="card bg-secondary shadow border-0">
                                                <div class="card-header bg-transparent pb-2">
                                                    <h4 class="text-center mt-2 mb-3"><?php echo e(__('Call Waiter')); ?></h4>
                                                </div>
                                                <div class="card-body px-lg-5 py-lg-5">
                                                    <form role="form" method="post" action="<?php echo e(route('call.waiter')); ?>">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo $__env->make('partials.fields',$fields, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                        <div class="text-center">
                                                            <button type="submit" class="btn btn-primary my-4"><?php echo e(__('Call Now')); ?></button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php $__env->stopSection(); ?>
                            <?php if($showLanguagesSelector): ?>
                            <?php $__env->startSection('addiitional_button_1'); ?>
                            <div class="dropdown web-menu">
                                <a href="#" class="btn btn-neutral dropdown-toggle " data-toggle="dropdown" id="navbarDropdownMenuLink2">
                                    <!--<img src="<?php echo e(asset('images')); ?>/icons/flags/<?php echo e(strtoupper(config('app.locale'))); ?>.png" /> --> <?php echo e($currentLanguage); ?>

                                </a>
                                <ul class="dropdown-menu" aria-labelledby="">
                                    <?php $__currentLoopData = $restorant->localmenus()->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($language->language!=config('app.locale')): ?>
                                    <li>
                                        <a class="dropdown-item" href="?lang=<?php echo e($language->language); ?>">
                                            <!-- <img src="<?php echo e(asset('images')); ?>/icons/flags/<?php echo e(strtoupper($language->language)); ?>.png" /> --> <?php echo e($language->languageName); ?>

                                        </a>
                                    </li>
                                    <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                            <?php $__env->stopSection(); ?>
                            <?php $__env->startSection('addiitional_button_1_mobile'); ?>
                            <div class="dropdown mobile_menu">

                                <a type="button" class="nav-link  dropdown-toggle" data-toggle="dropdown"id="navbarDropdownMenuLink2">
                                    <span class="btn-inner--icon">
                                        <i class="fa fa-globe"></i>
                                    </span>
                                    <span class="nav-link-inner--text"><?php echo e($currentLanguage); ?></span>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="">
                                    <?php $__currentLoopData = $restorant->localmenus()->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($language->language!=config('app.locale')): ?>
                                    <li>
                                        <a class="dropdown-item" href="?lang=<?php echo e($language->language); ?>">
                                           <!-- <img src="<?php echo e(asset('images')); ?>/icons/flags/<?php echo e(strtoupper($language->language)); ?>.png" /> ---> <?php echo e($language->languageName); ?>

                                        </a>
                                    </li>
                                    <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                            <?php $__env->stopSection(); ?>
                            <?php endif; ?>

                            <?php $__env->startSection('js'); ?>
                            <script>
                                var CASHIER_CURRENCY = "<?php echo config('settings.cashier_currency') ?>";
                                var LOCALE = "<?php echo App::getLocale() ?>";
                                var IS_POS = false;
                                <?php if(!$restorant->categories->isEmpty()): ?>

                                        $("#<?php echo e($aberto); ?>_titulo").show();
                                $("#<?php echo e($aberto); ?>_box").show();
                                <?php endif; ?>
                                        function share(){

                                        if (navigator.share) {
                                        navigator.share({
                                        title: document.title,
                                                text: "<?php echo e($restorant->name); ?>",
                                                url: window.location.href
                                        })
                                                .then(() => console.log('Successful share'))
                                                .catch(error => console.log('Error sharing:', error));
                                        }

                                        }


                                <?php if(count($banners) > 0): ?>
                                        $(document).ready(function ($) {
                                $('#modal-advertise').modal('show');
                                });
                                <?php endif; ?>
                            </script>
                            <script src="<?php echo e(asset('custom')); ?>/js/order.js"></script>
                            <?php echo $__env->make('restorants.phporderinterface', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> 
                            <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.front', ['class' => ''], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/borapedi/public_html/resources/views/restorants/show.blade.php ENDPATH**/ ?>