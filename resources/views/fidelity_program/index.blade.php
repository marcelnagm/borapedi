@extends('layouts.app', ['title' => __('Drivers')])

@section('content')
<style>
     ol.carousel-indicators li,
ol.carousel-indicators li.active {
  float: left;
  width: calc(100%/{{count($setup['items'] )}})  !important;
  height: 10px;
  margin: 0;
  border-radius: 0;
  border: 0;
  background: #e3e5e8 !important;
}
ol.carousel-indicators {
  position: absolute;
  bottom: 0;
  margin: 0;
  left: 0;
  right: 0;
  width: auto;
}

ol.carousel-indicators li.active {
  background: #5e72e4 !important;
}  

.carousel-control-prev-icon, .carousel-control-next-icon {
    height: 20px;
    width: 20px;
    outline: black;
    background-color: rgba(0, 0, 0, 0.3);
    background-size: 100%, 100%;
    border-radius: 50%;
    border: 1px solid black;
}
</style>
<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
</div>

<div class="container-fluid mt--7">
    <div class="row">
        <div class="col card shadow">
            <div class="card-header border-0">
                <div class="row align-items-center">
                    <div class="col-12">
                        <h3 class="mb-0">Programas de Fidelidade</h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div id="blogCarousel" class="carousel slide" data-ride="carousel">                         
                    <div class="carousel-inner">
                        @for($i = 0; $i < count($setup['items'] ); $i++) 
                        <?php $item = $setup['items'][$i];  ?>
                        <div class="carousel-item @if($i==0) {{'active'}} @endif">
                            <div class="row">                                          
                                <div class="col-12">
                                    <div class="card mb-4 mb-xl-0 bg-secondary">


                                        <div class="table-responsive">

                                            <table class="table align-items-center table-flush">
                                                <tr>
                                                    <td>Programa de Fidelidade - {{ $item->restorant()->name }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Regras
                                                        <p>
                                                            @if($item->type_target == 0 )
                                                            Ao fazer {{ $item->target_orders }} pedidos de pelo menos R${{ $item->target_value }}  você tem direito ao benefício.
                                                            @else
                                                            Ao fazer R${{ $item->target_value }} em compras no restaurante  você tem direito ao benefício. 
                                                            @endif       
                                                        </p>
                                                    </td>
                                                </tr>
                                                <td>Beneficio:

                                                    <p>
                                                        @if ($item->type_reward == 0)
                                                        Cupom de {{ $item->type_coupon == 0 ? $item->reward." ".config('settings.cashier_currency') : $item->reward." %"}}
                                                        @else
                                                        Nao Disponivel
                                                        @endif
                                                    </p>
                                                </td>
                                                <tr>
                                                    <td>
                                                        <?php
                                                        $buys = auth()->user()->BuysByRestaurant($item->restorant()->id, 1);

                                                        ?>
                                                        <div class="progress-wrapper">
                                                            <div class="progress-info">
                                                                <div class="progress-label">
                                                                    <span>Progresso:</span>
                                                                    @if($item->type_target == 0 )
                                                                     <?php
                                                        $buys = auth()->user()->BuysByRestaurant($item->restorant()->id, 1);
                                                        ?>
                                                                    {{$buys['cont']}} Feitos / {{$item->target_orders }} Necessãrios 
                                                                    <?php $per = $item->target_orders > $buys['cont'] ? ($buys['cont'] / $item->target_orders) * 100 : 100; ?>
                                                                    @else
                                                                     <?php
                                                        $buys = auth()->user()->BuysByRestaurant($item->restorant()->id, 1,$item->target_value);

                                                        ?>
                                                                    <?php $per = $item->target_value > $buys['total'] ? ($buys['total'] / $item->target_value) * 100 : 100; ?>
                                                                    R${{ $buys['total']}} Comprados / R${{$item->target_value}} Necessãrios 
                                                                    @endif       
                                                                </div>

                                                            </div>
                                                            <div class="progress"  style="width: 300px">
                                                                <div class="progress-bar bg-primary" role="progressbar" aria-valuenow="{{$per}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$per}}%;"></div>

                                                            </div>
                                                            <span>{{number_format($per,2)}}%</span>    
                                                        </div>                                

                                                        </div>

                                                    </td>
                                                </tr>
                                                <tr>                       
                                                    <td>
                                                        Recompensa disponivel: 
                                                        @if(auth()->user()->fidelity_program_reward($item->id))
                                                        <a class="btn btn-sm btn-primary" href="{{ route('coupons.index_client') }}"> Visualizar Cupom</a>
                                                        @else
                                                        Não
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="">
                                                        <a class="btn btn-success" href="{{route('vendor',['alias'=>$item->restorant()->alias])}}"> Visitar Restaurante</a>
                                                    </td>
                                                </tr>

                                            </table>
                                        </div>
                                    </div>
                                </div>                                    </div>
                        </div>
                        @endfor
                    </div>
                    <a class="carousel-control-prev" href="#blogCarousel" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only bg-primary">Anterior</span>
                    </a>
                    <a class="carousel-control-next" href="#blogCarousel" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Proximo</span>
                    </a>
                    <ol class="carousel-indicators">

                        <li data-target="#blogCarousel" data-slide-to="0" class="active"></li>
                        @for($i = 1; $i < count($setup['items'] ); $i++) 

                        <li data-target="#blogCarousel" data-slide-to="{{$i}}"></li>

                        @endfor 
                    </ol>

                </div>
            </div>





        </div>

        @include('layouts.footers.auth')

    </div>
</div>
@endsection