<div  class="mt--7">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Programa de Fidelidade</h3>
                        </div>

                        <div class="col-4 text-right">

                            <a href="{{route('fidelity_program.create')}}" class="btn btn-sm btn-primary">Adicionar</a>

                        </div>
                    </div>

                </div>
                @if(count($setup4['items']))
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                        <th>Descricao</th>
                        <th>Meta </th>
                        <th>Prêmio</th>
                        <th>Tipo</th>
                        <th>Período</th>                        
                        <th>Ativo</th>
                        <th>{{ __('crud.actions') }}</th>
                        

                        </thead>
                        @foreach ($setup4['items'] as $item)
                        <tr>
                            <td>{{ $item->description }}</td>
                            <td>{{ $item->target }}</td>
                            <td>{{ $item->reward }}</td>
                            <td>{{ $item->type }}</td>
                            <td>{{ $item->active_from }} /{{ $item->active_to }}</td>
                            <td>{{ $item->active }}</td>
                            <td>
                                <a href="fidelity/{{$item->id }}/edit" class="btn btn-primary btn-sm">{{ __('crud.edit') }}</a>
                                <a href="fidelity/del/{{$item->id }}" class="btn btn-danger btn-sm">{{ __('crud.delete') }}</a>
                            </td>
                        </tr>
                        @endforeach </table>
                </div>
                @endif
                <div class="card-footer py-4">
                    @if(count($setup4['items']))
                    <nav class="d-flex justify-content-end" aria-label="...">
                        {{ $setup4['items']->links() }}
                    </nav>
                    @else
                    <h4>{{__('crud.no_items',['items'=>"Programa de Fidelidade"])}}</h4>
                    @endif
                </div>



            </div>
</div>
