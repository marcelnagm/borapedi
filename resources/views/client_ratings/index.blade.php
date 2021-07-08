
<div  class="container-fluid mt--7">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Classificação dos CLientes</h3>
                        </div>

                        <div class="col-4 text-right">

                            <a href="client_ratings/create" class="btn btn-sm btn-primary">Adicionar</a>

                        </div>
                    </div>

                </div>

                @if(count($setup2['items']))
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            @if(isset($fields))
                            @foreach ($fields as $field)
                        <th>{{ __( $field['name'] ) }}</th>
                        @endforeach 
                        <th>{{ __('crud.actions') }}</th>
                        @else
                        @yield('thead')
                        @endif


                        </thead>
                        <tbody>
                            @foreach ($setup2['items'] as $item)
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->period }} -Mes(ês)</td>
                                <td>R${{ $item->val}}</td>                 
                                <td>
                                    <a href="{{ route( "client_ratings.edit",$item) }}" class="btn btn-primary btn-sm">Editar</a>
                                    <a href="{{ route( "client_ratings.delete",$item) }}" class="btn btn-danger btn-sm">Deletar</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
                <div class="card-footer py-4">
                    @if(count($setup2['items']))
                    <nav class="d-flex justify-content-end" aria-label="...">
                        {{ $setup2['items']->links() }}
                    </nav>
                    @else
                    <h4>{{__('crud.no_items',['items'=>$item_names])}}</h4>
                    @endif
                </div>
                


            </div>
        </div>
    </div>
</div>
