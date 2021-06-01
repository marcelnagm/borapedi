@if(auth()->user()->hasRole('admin'))


<td class="text-right">
    <div class="dropdown">
        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-ellipsis-v"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">

            <form action="{{ route('clients.destroy', $client) }}" method="post">
                @csrf
                @method('delete')
                <button type="button" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to deactivate this user?") }}') ? this.parentElement.submit() : ''">
                    {{ __('Deactivate') }}
                </button>
            </form>

        </div>                                                
    </div>
</td>
@endif
@if(auth()->user()->hasRole('owner'))


<td class="text-right">
        
    <a class="btn btn-info"  href="{{ route('clients.show', $client) }}" >Detalhes</a>                 
</td>
@endif