<div id="form-group-{{ $id }}" class="form-group {{ $errors->has($id) ? ' has-danger' : '' }}  @isset($class) {{$class}} @endisset">

    @isset($separator)
    <br />
    <h4 class="display-4 mb-0">{{ __($separator) }}</h4>
    <hr />
@endisset

    <label class="form-control-label">{{ __($name) }}</label><br />
@isset($help)
        <span type="button" class="" data-toggle="tooltip" data-html="true" title="{{$help}}">
             &nbsp;
            <i class="ni ni-chat-round"></i>
        </span >
        @endisset
    <select class="form-control form-control-alternative   @isset($classselect) {{$classselect}} @endisset"  name="{{ $id }}" id="{{  $id }}">
        @if($edit ?? '' ==true)
        <option disabled value> {{ __('Select')." ".__($name)}} </option>
         @else
        <option disabled selected value> {{ __('Select')." ".__($name)}} </option>
        @endif
        @foreach ($data as $key => $item)

            @if (is_array(__($item)))
                <option value="{{ $key }}">{{ $item }}</option>
            @else
                @if (old($id)&&old($id).""==$key."")
                    <option  selected value="{{ $key }}">{{ __($item) }}</option>
                @elseif (isset($value)&&strtoupper($value."")==strtoupper($key.""))
                    <option  selected value="{{ $key }}">{{ __($item) }}</option>
                @elseif (app('request')->input($id)&&strtoupper(app('request')->input($id)."")==strtoupper($key.""))
                    <option  selected value="{{ $key }}">{{ __($item) }}</option>
                @else
                    <option value="{{ $key }}">{{ __($item) }}</option>
                @endif
            @endif
            
        @endforeach
    </select>


    @isset($additionalInfo)
        <small class="text-muted"><strong>{{ __($additionalInfo) }}</strong></small>
    @endisset
    @if ($errors->has($id))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first($id) }}</strong>
        </span>
    @endif
</div>
