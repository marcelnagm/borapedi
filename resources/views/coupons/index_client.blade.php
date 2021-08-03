@extends('layouts.app', ['title' => 'Meus Coupons'])
@section('content')
<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    </div>
    <div class="container-fluid mt--7">
        <div class="row" style="width: 800px">
        <br/>
        <div class="card bg-secondary shadow col-12">
            <div class="card-header bg-white border-0 col-12" style="width: 1024px" >
                <div class="row align-items-center">
                    <div class="col-8">
                        <h3 class="mb-0">Meus Cupons</h3>                            
                    </div>                       
                </div>
            </div>
            <div class="card-body bg-white border-0 col-lg-12">
                 
                <div class="table-responsive">
                    
                    

                            @if(count($setup['items']))
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                        <th>Nome</th>
                        <th>Codigo do cupom</th>
                        <th>Tipo</th>
                        <th>Inicio</th>
                        <th>Fim</th>


                        </thead>
                        @foreach ($setup['items'] as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->code }}</td>
                            <td>{{ $item->type == 0 ? $item->price." ".config('settings.cashier_currency') : $item->price." %"}}</td>
                            <td>{{ $item->active_from }}</td>
                            <td>{{ $item->active_to }}</td>
                        </tr>
                        @endforeach

                    </table>
                    @endif
                </div>
            </div>
        </div>
        @include('layouts.footers.auth')
    </div>
    @endsection
 
