<div class="p-2">
Tempo Estimado de Entrega<span class="font-weight-light"></span>
<div class="card-content">
    @if($timeToPrepare != 0)
    {{$timeToPrepare}}min - {{$timeToPrepare*2}}min
    @else
    Não Informado
    @endif
</div>
</div>