@extends('layouts.app', ['title' => 'Campanha de Marketing '])
@section('admin_title')
Campanha de Marketing
@endsection
@section('content')
<div class="header bg-gradient-info pb-6 pt-5 pt-md-8">
    <div class="container-fluid">

        <div class="nav-wrapper">
            <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="res_menagment" role="tablist">

                <li class="nav-item ">
                    <a class="nav-link mb-sm-3 mb-md-0 active " id="tabs-menagment-main" data-toggle="tab" href="#menagment" role="tab" aria-controls="tabs-menagment" aria-selected="true"><i class="ni ni-badge mr-2"></i>Promoções</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link mb-sm-3 mb-md-0 " id="tabs-menagment-main" data-toggle="tab" href="#client_ratings" role="tab" aria-controls="tabs-menagment" aria-selected="true"><i class="ni ni-diamond mr-2"></i>Classificação dos Clientes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mb-sm-3 mb-md-0 " id="tabs-menagment-main" data-toggle="tab" href="#coupons" role="tab" aria-controls="tabs-menagment" aria-selected="true"><i class="ni ni-tag  mr-2"></i>Coupons</a>
                </li>                
            </ul>
        </div>

    </div>
</div>


<div class="container-fluid ">
    <div class="row">
        <div class="col-12">
            <br />

            @include('partials.flash')

            <div class="tab-content" id="tabs">


                <!-- Tab Managment -->
                <div class="tab-pane fade show active" id="menagment" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                    @include('offer.index') 
                </div>

                <!-- Tab Apps -->
                <div class="tab-pane fade show" id="client_ratings" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                    @include('client_ratings.index',['setup' => $setup2]) 
                </div>

                <!-- Tab Location -->
                <div class="tab-pane fade show" id="coupons" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                    @include('coupons.index',['setup' => $setup]) 
                </div>


            </div>
        </div>
    </div>
    @include('layouts.footers.auth')
</div>
@endsection

@section('js')
@endsection

