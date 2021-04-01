<div class="pl-lg-4">
    <form id="restorant-form" method="post" action="{{ route('deliverytax.post', $restorant) }}" autocomplete="off" enctype="multipart/form-data">
        @csrf
        @method('post')
        <input type="hidden" name='restaurant_id' id="rid" value="{{ $restorant->id }}"/>
         @include('partials.fields',['fields'=>[
            ['ftype'=>'input','name'=>"Delivery Distance",'id'=>"distance",'placeholder'=>"Delivery Distance",'required'=>true],
            ['ftype'=>'input','name'=>"Delivery Tax",'id'=>"cost",'placeholder'=>"Delivery Tax",'required'=>true],
        ]])
        <button type='submit' class="btn btn-success mt-4">{{ __('Save') }}</button>        
    </form>
</div>
