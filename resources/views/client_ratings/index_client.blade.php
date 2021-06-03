@extends('layouts.app', ['title' => 'Whatsapp '])
@section('admin_title')
Minha Fidelização
@endsection
@section('content')
<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8 " style="width: 1024px">
</div>
<div class="container-fluid mt--7">
    <div class="row" style="width: 800px">
        <br/>
        <div class="card bg-secondary shadow col-12">
            <div class="card-header bg-white border-0 col-12" style="width: 1024px" >
                <div class="row align-items-center">
                    <div class="col-8">
                        <h3 class="mb-0">Minha Fidelização</h3>                            
                    </div>                       
                </div>
            </div>
            <div class="card-body bg-white border-0 col-lg-12">
                 
                <div class="table-responsive">
                    
                    

                        <table class="table align-items-center table-stripe" id='result2'>                           
                            <thead class="thead-light">
                                <tr>
                                    <th class="" scope="col">Restaurante</th>
                                    <th class="" scope="col">Classificação</th>
                                    <th class="" scope="col">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($ratings)>0)
                                @foreach($ratings as $tax)
                                <tr>    
                                    <td class="">
                                        {{ $tax->restaurant()->name }} 
                                    </td>
                                
                                    <td class="">
                                        {{ $tax->rating()->name }} 
                                    </td>
                                    <td class="">
                                        <a class="btn btn-success" href="{{route('vendor',['alias'=>$tax->restaurant()->alias])}}"> Visitar Restaurante</a>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan='2'>Nenhuma Fidelização Ainda</td>
                                </tr>
                                @endif
                            </tbody>

                    </table>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth')
    </div>
    @endsection
 
