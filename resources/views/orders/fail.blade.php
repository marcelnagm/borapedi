@extends('layouts.app', ['title' => ''])
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="card shadow border-0 mt-8">
            <div class="card-body text-center">
                <div class="swal2-icon swal2-error swal2-animate-error-icon" style="display: flex;">
                    <div class="swal2-error-circular-line-left" style="background-color: rgb(255, 255, 255);"></div>
                    <span class="swal2-error-line-tip"></span>
                    <span class="swal2-error-line-long"></span>
                    <div class="swal2-error-ring"></div>
                    <div class="swal2-error-fix" style="background-color: rgb(255, 255, 255);"></div>
                    <div class="swal2-error-circular-line-right" style="background-color: rgb(255, 255, 255);"></div>
                    <font style="color: red;font-size: 40px;">X</font>
                </div>
                <h2 class="display-2">Ops, Algo deu errado</h2>
                <h2 class="display-2">O que você deseja fazer?</h2>
                <h1 class="mb-4">
                    <span class="badge badge-primary">{{ __('Order')." #".$order->id }}</span>
                </h1>
                <div class="col-12">
                    <div class="alert alert-danger " >
                        Houve um erro no seu pagamento                        
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <div class="col-8">                        
                        <a href="/mercadopago/pay/{{$order->id }}" class="btn btn-success btn-lg" style="margin-bottom: 10px;">                                                    
                            Tentar pagar novamente
                        </a>
                        </br>
                        <a href="/order/{{$order->id }}/change" class="btn btn-neutral btn-lg" style="background-color: #f7f267  !important;margin-bottom: 10px;">                                                    
                           Pagar na entrega
                        </a>                        
                        </br>
                        <button  class="btn btn-danger btn-lg" onclick="remove()" style="margin-bottom: 10px;">                                                    
                            Cancelar o Pedido                       
                        </button>
                        
                       

                    </div>
                </div
            </div>
        </div>
    </div>
</div>
<script>
function remove(){
var r = confirm("Deseja realmente cancelar?");
if (r == true) {
  window.location.href = "/order/{{$order->id }}/destroy";
} else {

}
}
</script>
    
@endsection





