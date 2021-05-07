@extends('layouts.app', ['title' => 'Whatsapp '])
@section('admin_title')
{{ config('settings.url_route')." ".__('Management')}}
@endsection
@section('content')
<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
</div>
<div class="container-fluid mt--7">
    <div class="row">
        <br/>
        <div class="card bg-secondary shadow col-lg-12">
            <div class="card-header bg-white border-0">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h3 class="mb-0">Whatsapp</h3>                            
                    </div>                       
                </div>
            </div>
            <div class="card-body bg-white border-0">
                Habilitar notificações de whatsapp <input type="checkbox" id='whatsapp'>
                <div id='qr'>

                </div>
                <div class="table-responsive">
                    <a class="btn btn-primary" href="{{ route('whatsapp.new') }}">Adicionar</a>
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

            $("#whatsapp").change(function () {
                if (this.checked == true) {

                } else {

                }

            });
        });


    </script>

    @endsection

