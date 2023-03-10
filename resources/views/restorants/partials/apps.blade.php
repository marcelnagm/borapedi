<div class="card card-profile bg-secondary shadow">
    <div class="card-header">

        <div class="row align-items-center">
            <div class="col-8">
                <h3 class="mb-0">Meios de Pagamento</h3>
            </div>

        </div>
    </div>
    <div class="card-body">
        <form id="restorant-apps-form" method="post" autocomplete="off" enctype="multipart/form-data" action="{{ route('admin.restaurant.updateApps',$restorant) }}">
            
            @csrf
            @method('put')
            @include('partials.fields',['fields'=>$appFields])
          @if (config('settings.is_whatsapp_ordering_mode'))
                @include('restorants.partials.social_info',['restorant'=>$restorant])  
         @endif

            <div class="text-center">
                <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
            </div>
        </form>
          
    </div>
</div>