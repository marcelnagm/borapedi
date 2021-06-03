@extends('layouts.app', ['title' => __('Clients Management')])

@section('content')
@include('drivers.partials.header', ['title' => __('Detalhes do Cliente')])

<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-xl-12 order-xl-1">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Detalhes do Cliente</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('clients.index') }}" class="btn btn-sm btn-primary">Voltar a Lista</a>
                        </div>
                    </div>
                    <div class="row col-12">                            
                        <table class="table-responsive">
                            <tr>
                                <td>
                                    <h4>Nome :</h4> 
                                    {{$client->name}}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h4>Telefone :</h4> 
                                    {{$client->phone}}
                                </td>
                            </tr>
                            <tr>
                                <td><h4>Email :</h4> 
                                    {{$client->email}}
                                </td>                                                        
                            </tr>
                            <tr>
                                <td><h4>Classificação :</h4> 
                                    {{$client->ClientHasRating(auth()->user()->restorant()->first()->id)}}
                                </td>                                                        
                            </tr>
                        </table>
                    </div>
                    <div class="row col-12"> 
                        <h4>Orders :</h4> 
                        <table class="table table-stripe">
                            <thead>
                            <th>
                                Id
                            </th>
                            <th>
                                Data do Pedido
                            </th>
                            <th>
                                Valor do Pedido
                            </th>
                            </thead>
                           <?php  $i = 0;
                             $total = 0; ?>
                            @foreach($client->OrdersFromRestorant() as $order)
                            <?php $i++;                           
                             $total = $order->order_price + $total; ?>
                            <tr>
                                <td>
                                    <a class="btn btn-primary" alt="Detalhes do pedido" href="{{ route('orders.show',$order->id )}}">#{{ $order->id }}</a>
                                </td>                            
                                <td>
                                    {{ $order->created_at }}
                                </td>
                                <td>
                                    R${{ $order->order_price }}
                                </td>
                            </tr>
                            @endforeach
                            <tr>
                                <td>
                                    <h4>Qtd de pedidos :</h4> 
                                    {{$i}}
                                </td>                            
                                <td>
                                   <h4>Total em Pedidos:</h4> 
                                    {{$total}}
                                </td>
                                <td>
                                    <h4>Media por Pedido:</h4> 
                                    {{$total/$i}}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="card-body">

                </div>
            </div>
        </div>
    </div>
</div>

@include('layouts.footers.auth')    
@endsection
