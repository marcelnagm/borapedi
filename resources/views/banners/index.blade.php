<div  class="mt--7">
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Ofertas (Banners)</h3>
                        </div>

                        <div class="col-4 text-right">

                            <a href="banners/create" class="btn btn-sm btn-primary">Adicionar</a>

                        </div>
                    </div>

                </div>
                @if(count($setup3['items']))
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                        <th>Nome </th>
                        <th>Inicio</th>
                        <th>Fim</th>
                        <th>{{ __('crud.actions') }}</th>                        
                        </thead>
                        @foreach ($setup3['items'] as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->active_from }}</td>
                            <td>{{ $item->active_to }}</td>
                            <td>
                                <a href="banners/{{$item->id }}/edit" class="btn btn-primary btn-sm">{{ __('crud.edit') }}</a>
                                <a href="banners/del/{{$item->id }}" class="btn btn-danger btn-sm">{{ __('crud.delete') }}</a>
                            </td>
                        </tr>
                        @endforeach </table>
                </div>
                @endif
                <div class="card-footer py-4">
                    @if(count($setup3['items']))
                    <nav class="d-flex justify-content-end" aria-label="...">
                        {{ $setup3['items']->links() }}
                    </nav>
                    @else
                    <h4>{{__('crud.no_items',['items'=>"Coupons"])}}</h4>
                    @endif
                </div>



            </div>
        </div>
    </div>
</div>
