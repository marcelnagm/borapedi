    <form id="restorant-form" method="post" action="{{ route('deliverytax.post', $restorant) }}" autocomplete="off" enctype="multipart/form-data">
        @csrf
        @method('post')
        <input type="hidden" name='restaurant_id' id="rid" value="{{ $restorant->id }}"/>
         @include('partials.fields',['fields'=>[
            ['ftype'=>'input','name'=>"Distância",'id'=>"distance",'placeholder'=>"coloque a distância em Km",'required'=>true],
            ['ftype'=>'input','name'=>"Taxa",'id'=>"cost",'placeholder'=>"Preço em Reais",'required'=>true],       
        ]])        
        <button type='submit' class="btn btn-success mt-4">{{ __('Save') }}</button>        
    </form>
