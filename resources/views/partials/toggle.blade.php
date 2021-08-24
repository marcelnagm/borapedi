<div class="form-group{{ $errors->has($id) ? ' has-danger' : '' }}">
    
    <label class="form-control-label" for="{{ $id }}">{{ __($name) }}</label>
    <label class="custom-toggle" style="float: right">
        <input type="checkbox"  name="{{ $id }}" id="{{ $id }}" <?php if($checked){echo "checked";}?>>
        <span class="custom-toggle-slider rounded-circle"></span>
    </label>
    @isset($help)
        <span type="button" class="" data-toggle="tooltip" data-html="true" title="{{$help}}">
             &nbsp;
            <i class="ni ni-chat-round"></i>
        </span >
        @endisset
    @if ($errors->has($id))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first($id) }}</strong>
        </span>
    @endif
</div>