
<div  class="mt--7">
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">                        
                        <div class="col-8">
                            @if(isset($fidelity))
                            <h3 class="mb-0">Editando o programa de fidelidade</h3>
                            @else
                            <h3 class="mb-0">Criar um programa de fidelidade</h3>
                            @endif
                        </div>
                        </div>
                    <div class="row align-items-center">   
                          <div class="col-12">
                        @if(isset($fidelity))
                        <form method="post" action="{{ route('fidelity_program.update', ['id'=> $fidelity->id]) }}" autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            @else
                            <form method="post" action="{{ route('fidelity_program.store') }}" autocomplete="off" enctype="multipart/form-data">
                                @csrf
                                @endif
                                @include('fidelity_program.form')
                                <div>
                                    @if(isset($fidelity))
                                    <button type="submit" class="btn btn-primary mt-4">{{ __('Update')}}</button>
                                    @else
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                                    @endif
                                </div>
                            </form>
                    </div>          
                    </div>          
                </div>
            </div>
        </div>
    </div>
</div>