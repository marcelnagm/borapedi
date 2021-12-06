@extends('layouts.app', ['title' => 'Whatsapp '])
@section('admin_title')
{{ config('settings.url_route')." ".__('Management')}}
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
                        <h3 class="mb-0">Whatsapp</h3>                            
                    </div>                       
                </div>
            </div>
            <div class="card-body bg-white border-0 col-lg-12">
                 <table class="table align-items-center" >                           
                                                  
                    </table>
                <br>
                <div class="table-responsive">
                    <a class="btn btn-primary" href="{{ route('whatsapp.new') }}">Adicionar mensagens personalizadas</a>
                    <table class="table align-items-center" id='result'>                           
                        @include('whatsapp.list')                            
                    </table>
                </div>
            </div>


        </div>
        @include('layouts.footers.auth')
    </div>
    @endsection

    @section('js')

    <script>
        $(document).ready(function ($) {
            //check if h
           
        });
        var session = "{{auth()->user()->restorant->phone}}";
        var urlRemove = "https://api.borapedi.com:3333/Close";
        
        function remove_session(){
            $.post(urlRemove, {SessionName: session}, function (data) {
                    
                        document.location.reload(true);
                
                });
        }
        
    </script>

    @endsection

