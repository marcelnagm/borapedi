<form   autocomplete="off" enctype="multipart/form-data">
    @csrf
    @method('post')
    <input type="hidden" name='restaurant_id' id="rid" value="{{ $restorant->id }}"/>
    @include('partials.fields',['fields'=>[
    ['ftype'=>'input','name'=>"Distância",'id'=>"distance",'placeholder'=>"coloque a distância em Km",'required'=>true],
    ['ftype'=>'input','name'=>"Taxa",'id'=>"cost",'placeholder'=>"Preço em Reais",'required'=>true],       
    ]])        
    <button type='button' onclick="enviar_tax()" class="btn btn-success mt-4">{{ __('Save') }}</button>           
</form>