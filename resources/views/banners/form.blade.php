<div class="row">
    <div class="col-lg-12">
        @if(isset($banner))
            @include('partials.input',['class'=>"col-12", 'ftype'=>'input','name'=>"Name",'id'=>"name",'placeholder'=>"Enter banner name",'required'=>true, 'value'=>$banner->name])
        @else
            @include('partials.input',['class'=>"col-12", 'ftype'=>'input','name'=>"Name",'id'=>"name",'placeholder'=>"Enter banner name",'required'=>true])
        @endif
    </div>
    </div>
        @if(isset($banner))
            <input name="type" class="form-control" placeholder="{{ __('Active from') }}" value="{{ old('type', $banner->type) }}" type="hidden">
            <input name="vendor_id" class="form-control" placeholder="{{ __('Active from') }}" value="{{ old('vendor_id', $banner->vendor_id) }}" type="hidden">        
        @else
        
        <input name="type" class="form-control" placeholder="{{ __('Active from') }}" value="0" type="hidden">
        <input name="vendor_id" class="form-control" placeholder="{{ __('Active from') }}" value="{{ auth()->user()->restorant()->first()->id}}" type="hidden">        
        @endif        
<div class="row">
    <div class="col-lg-6">
        <div class="input-daterange datepicker row align-items-center" style="margin-left: 15px;">
           <div class="form-group">
                <label class="form-control-label">{{ __('Active from') }}</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                    </div>
                    @if(isset($banner))
                        <input name="active_from" class="form-control" placeholder="{{ __('Active from') }}" value="{{ old('active_from', $banner->active_from) }}" type="text">
                    @else
                        <input name="active_from" class="form-control" placeholder="{{ __('Active from') }}" type="text">
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="input-daterange datepicker row align-items-center" style="margin-left: 15px;">
           <div class="form-group">
                <label class="form-control-label">{{ __('Active to') }}</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                    </div>
                    @if(isset($banner))
                        <input name="active_to" class="form-control" placeholder="{{ __('Active to') }}" value="{{ old('active_to', $banner->active_to) }}" type="text">
                    @else
                        <input name="active_to" class="form-control" placeholder="{{ __('Active to') }}" type="text">
                    @endif
                </div>
            </div>
        </div>
    </div>
    </div>
    <div class="row">
    <div class="col-md-3">
        @if(isset($banner))
            @include('partials.images',['image'=>['name'=>'banner_image','label'=>__('Image'),'value'=>$banner->imgm,'style'=>'width: 200px; height: 100px;']])
        @else
            @include('partials.images',['image'=>['name'=>'banner_image','label'=>__('Image'),'value'=>'https://www.fastcat.com.ph/wp-content/uploads/2016/04/dummy-post-square-1-768x768.jpg','style'=>'width: 200px; height: 200px;']])
        @endif
    </div>
</div>
