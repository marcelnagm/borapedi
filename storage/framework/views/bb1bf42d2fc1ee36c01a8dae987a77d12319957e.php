<?php $__env->startSection('content'); ?>
<style>
    
    .cart_adapt{
                width: 100vw;
    height: 47vh;
    margin-right: 200px;
        }
        
     @media  only screen and (max-width:1023px) {
        .cart_adapt{
                width: 100vw;
    height: 44vh;
    margin-right: 200px;
        }
        
        .cart_adapt_left {
            /*width: 200%;*/
        }
     }
</style>

<div class="container">        
            <?php if(session('status')): ?>
            <div class="card bg-secondary shadow border-0">
                <div class="card-body">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php echo e(session('status')); ?>

                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            </div>
            <?php endif; ?>


                     <div class="card bg-secondary shadow ">
                <div class="card-body row">
                    
                    <?php if(config('app.isft')&&(strlen(config('settings.google_client_id'))>3||strlen(config('settings.facebook_client_id'))>3)): ?>
                       
                        
                        <div class="col text-center  left">
                            <img src="/social/img/wpordering.svg" class="cart_adapt rounded" style="    margin-left: 3em;" alt="Responsive image" width="80%">
                        </div>
                        <div class="col text-center cart_adapt_left left">
                            <div class="text-muted text-center ">Como deseja entrar?</div>
                        <div class="btn-wrapper ">
                            </hr>    
                            <?php if(strlen(config('settings.google_client_id'))>3): ?>
                            <a style="width:100%;margin-bottom:10px;" href="<?php echo e(route('google.login')); ?>" class="btn btn-neutral btn-icon">
                                <span class="btn-inner--icon"><img class="fas" src="<?php echo e(asset('argonfront/img/google.svg')); ?>"></span>
                                <span class="btn-inner--text"> Logar com Google</span>
                            </a>
                            <?php endif; ?>
                            <br>
                            <?php if(strlen(config('settings.facebook_client_id'))>3): ?>
                            <a style="width:100%" href="<?php echo e(route('facebook.login')); ?>" class="btn btn-neutral btn-icon btn-lg">                                
                                <span class="btn-inner--icon"><img class="fas" src="<?php echo e(asset('custom/img/facebook.png')); ?>"></span>
                                <span class="btn-inner--text">Logar com Facebook</span>
                            </a>                           
                            <br>
                            <?php endif; ?>                          <br>
                            <a style="width:100%" href="#" class="btn btn-neutral btn-icon" onclick="$('#login-form').show('1000')">
                                <span  class="btn-inner--icon"><i styl="color:gold;"  class="fas fa-envelope"></i>></span>
                                <span class="btn-inner--text">Logar com Email / Whatsappp</span>
                            </a>
                        </div>                    
                    <?php endif; ?>
                    <div  id="login-form"  style="display:none;">
                    <div class="nav-wrapper">
                        <ul class="nav nav-tabs nav-fill" id="res_menagment" role="tablist">

                            <li class="nav-item text-white">
                                <a class="nav-link mb-sm-3 mb-md-0 active " id="tabs-menagment-main" data-toggle="tab" href="#client" role="tab" aria-controls="tabs-menagment" aria-selected="true"><i class="ni ni-basket mr-2"></i>Cliente</a>
                            </li>
                            <li class="nav-item text-white">
                                <a class="nav-link mb-sm-3 mb-md-0 " id="tabs-menagment-main" data-toggle="tab" href="#admin" role="tab" aria-controls="tabs-menagment" aria-selected="true"><i class="ni ni ni-briefcase-24 mr-2"></i>Restaurante</a>
                            </li>                            
                        </ul>
                    </div>
                    <div class="tab-content" id="tabs">
                        <div class="tab-pane fade show active" id="client" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">

                            <form role="form" method="POST" action="<?php echo e(route('login.client')); ?>">
                                <?php echo csrf_field(); ?>

                                <div class="form-group<?php echo e($errors->has('phone') ? ' has-danger' : ''); ?> mb-3">
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-whatsapp "></i></span>
                                        </div>
                                        <input class="form-control<?php echo e($errors->has('phone') ? ' is-invalid' : ''); ?>" placeholder="Whatsapp" id="phone" type="phone" name="phone" value="<?php echo e(old('phone')); ?>" required autofocus>
                                    </div>
                                    <?php if($errors->has('phone')): ?>
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong><?php echo e($errors->first('phone')); ?></strong>
                                    </span>
                                    <?php endif; ?>
                                </div>                                

                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input class="custom-control-input" name="remember" id="customCheckLogin" type="checkbox" <?php echo e(old('remember') ? 'checked' : ''); ?>>
                                    <label class="custom-control-label" for="customCheckLogin">
                                        <span class="text-muted"><?php echo e(__('Remember me')); ?></span>
                                    </label>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-danger my-4"><?php echo e(__('Sign in')); ?></button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade show" id="admin" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">

                            <form role="form" method="POST" action="<?php echo e(route('login')); ?>">
                                <?php echo csrf_field(); ?>

                                <div class="form-group<?php echo e($errors->has('email') ? ' has-danger' : ''); ?> mb-3">
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                        </div>
                                        <input class="form-control<?php echo e($errors->has('email') ? ' is-invalid' : ''); ?>" placeholder="<?php echo e(__('Email')); ?>" type="email" name="email" value="<?php echo e(old('email')); ?>" required autofocus>
                                    </div>
                                    <?php if($errors->has('email')): ?>
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong><?php echo e($errors->first('email')); ?></strong>
                                    </span>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group<?php echo e($errors->has('password') ? ' has-danger' : ''); ?>">
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                        </div>
                                        <input class="form-control<?php echo e($errors->has('password') ? ' is-invalid' : ''); ?>" name="password" placeholder="<?php echo e(__('Password')); ?>" type="password" required>
                                    </div>
                                    <?php if($errors->has('password')): ?>
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong><?php echo e($errors->first('password')); ?></strong>
                                    </span>
                                    <?php endif; ?>
                                </div> 

                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input class="custom-control-input" name="remember" id="customCheckLogin" type="checkbox" <?php echo e(old('remember') ? 'checked' : ''); ?>>
                                    <label class="custom-control-label" for="customCheckLogin">
                                        <span class="text-muted"><?php echo e(__('Remember me')); ?></span>
                                    </label>
                                      
                        <a href="<?php echo e(route('password.request')); ?>" class="text-blue right                         <a href="<?php echo e(route('password.request')); ?>" class="text-blue right custom-control-label ">
                            <?php echo e(__('Forgot password?')); ?></small>
                        </a>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-danger my-4"><?php echo e(__('Sign in')); ?></button>
                                </div>                              
                            </form>
                        </div>

                    </div>
                </div>
                
                </div>
               
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>

    <script>

    $("#phone").mask("(00) 00000-0000");

    //$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    //    var target = $e(.target).attr("href") // activated tab
    ////        alert(target);
    //    if (target == "#client")
    //    {
    //
    //    }
    //    if (target == "#admin")
    //    {
    //
    //    }
    //});

    </script>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.front_nofooter_noheader', ['class' => 'bg'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/borapedi/public_html/resources/views/auth/login.blade.php ENDPATH**/ ?>