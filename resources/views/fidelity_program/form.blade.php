<div class="row">
    <div class="col-lg-12">
        @if(isset($banner))
        @include('partials.input',['class'=>"col-12", 'ftype'=>'input','name'=>"Description",'id'=>"description",'placeholder'=>"Nome do Programa",'required'=>true, 'value'=>$banner->description])
        @else
        @include('partials.input',['class'=>"col-12", 'ftype'=>'input','name'=>"Description",'id'=>"description",'placeholder'=>"Nome do Programa",'required'=>true])
        @endif
    </div>
</div>        
<div class="row">
    <div class="col-lg-12">
        @if(isset($banner))
        @include('partials.input',['class'=>"col-12", 'ftype'=>'input','name'=>"target",'id'=>"target",'placeholder'=>"Meta para alcancar o prêmio",'required'=>true, 'value'=>$banner->target])
        @else
        @include('partials.input',['class'=>"col-12", 'ftype'=>'input','name'=>"target",'id'=>"target",'placeholder'=>"Meta para alcancar o prêmio",'required'=>true])
        @endif
    </div>
</div>        
<div class="row">
    <div class="col-lg-12">
        @if(isset($banner))
        @include('partials.input',['class'=>"col-12", 'ftype'=>'input','name'=>"reward",'id'=>"reward",'placeholder'=>"prêmio",'required'=>true, 'value'=>$banner->reward])
        @else
        @include('partials.input',['class'=>"col-12", 'ftype'=>'input','name'=>"reward",'id'=>"reward",'placeholder'=>"prêmio",'required'=>true])
        @endif
    </div>
</div>        
<div class="row">
    <div class="col-lg-12">
        @if(isset($banner))
    @include('partials.select', ['class'=>"col-12",'name'=>"Type",'id'=>"type",'placeholder'=>"Select type",'data'=>['Fixed', 'Percentage'],'required'=>true, 'value'=>$banner->type])
        @else
            @include('partials.select', ['class'=>"col-12",'name'=>"Type",'id'=>"type",'placeholder'=>"Select type",'data'=>['Fixed', 'Percentage'],'required'=>true])
     @endif
    </div>
</div>        

<div class="row">
    <div class="col-md-6">
        <div class="input-daterange datepicker row align-items-center" style="margin-left: 15px;">
           <div class="form-group">
                <label class="form-control-label">{{ __('Active from') }}</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                    </div>
                    @if(isset($banner))
                        <input name="active_from" class="form-control" placeholder="{{ __('Active from') }}" value="{{ old('active_from', $coupon->active_from) }}" type="text">
                    @else
                        <input name="active_from" class="form-control" placeholder="{{ __('Active from') }}" type="text">
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="input-daterange datepicker row align-items-center" style="margin-left: 15px;">
           <div class="form-group">
                <label class="form-control-label">{{ __('Active to') }}</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                    </div>
                    @if(isset($banner))
                        <input name="active_to" class="form-control" placeholder="{{ __('Active to') }}" value="{{ old('active_to', $coupon->active_to) }}" type="text">
                    @else
                        <input name="active_to" class="form-control" placeholder="{{ __('Active to') }}" type="text">
                    @endif
                </div>
            </div>
        </div>
    </div>
<div class="row">
    <div class="col-lg-12">
        @if(isset($banner))
        @include('partials.bool', ['class'=>"col-12",'name'=>"Active",'id'=>"active",'placeholder'=>"Ativo?",'required'=>true, 'value'=>$banner->getActive()])
        @else
            @include('partials.bool', ['class'=>"col-12",'name'=>"Active",'id'=>"active",'placeholder'=>"Ativo?",'required'=>true])
     @endif
    </div>
</div>        

<input name="restaurant_id" class="form-control" placeholder="{{ __('Active from') }}" value="{{ auth()->user()->restorant()->first()->id}}" type="hidden">                