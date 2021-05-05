<div class="card card-profile shadow">
    <div class="card-header">
        <h5 class="h3 mb-0">{{ ucfirst(config('settings.url_route'))." ".__("Location")}} - Àreas Atendidads </h5>
    </div>
    <div class="card-body">
        <a href="{{ route('deliverytax.index') }}"  class="btn btn-primary">Alterar àreas</a>
        <div class="card shadow">            
            <div id="map_canvas" style="height: 80vh; width:60vw">


            </div>
        </div>
    </div>
</div>