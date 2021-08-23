
<div style="padding: 0 16px 0 16px" >
    {{ __('Comment') }}
<div class="card-content ">
    <div class="form-group{{ $errors->has('comment') ? ' has-danger' : '' }}">            
        <textarea name="comment" id="comment" class="form-control{{ $errors->has('comment') ? ' is-invalid' : '' }}" placeholder="{{ __( 'Your comment here' ) }} ..."></textarea>
        @if ($errors->has('comment'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('comment') }}</strong>
        </span>
        @endif
    </div>
</div>
</div>
