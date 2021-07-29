
<div  class="mt--7">
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Coupons</h3>
                        </div>

                        <div class="col-4 text-right">

                            <a href="coupons/create" class="btn btn-sm btn-primary">Adicionar</a>

                        </div>
                    </div>

                </div>

                @if(count($setup['items']))
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                        <th>Nome</th>
                        <th>Codigo do cupom</th>
                        <th>Tipo</th>
                        <th>Inicio</th>
                        <th>Fim</th>
                        <th>Quantidade</th>
                        <th>Utilizados</th>
                        <th>{{ __('crud.actions') }}</th>


                        </thead>
                        @foreach ($setup['items'] as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->code }}</td>
                            <td>{{ $item->type == 0 ? $item->price." ".config('settings.cashier_currency') : $item->price." %"}}</td>
                            <td>{{ $item->active_from }}</td>
                            <td>{{ $item->active_to }}</td>
                            <td>{{ $item->limit_to_num_uses }}</td>
                            <td>{{ $item->used_count }}</td>

                            <td>
                                <a href="coupons/{{$item->id }}/edit" class="btn btn-primary btn-sm">{{ __('crud.edit') }}</a>
                                <a href="coupons/del/{{$item->id }}" class="btn btn-danger btn-sm">{{ __('crud.delete') }}</a>
                            </td>
                        </tr>
                        @endforeach

                    </table>
                </div>
                @endif
                <div class="card-footer py-4">
                    @if(count($setup['items']))
                    <nav class="d-flex justify-content-end" aria-label="...">
                        {{ $setup['items']->links() }}
                    </nav>
                    @else
                    <h4>{{__('crud.no_items',['items'=>"Coupons"])}}</h4>
                    @endif
                </div>



            </div>
        </div>
    </div>
</div>