
<div class="card card-profile shadow">
    <div class="px-4">
      <div class="mt-5">
        <h3>{{ __(config('settings.label_on_custom_fields')) }}<span class="font-weight-light"></span></h3>
      </div>
      <div class="card-content border-top">
        <br />

      <br />
      @include('partials.fields',['fields'=>[
            ['ftype'=>'input','name'=>"Name",'id'=>"name",'placeholder'=>"Put your full name",'required'=>true],
            ['ftype'=>'input','name'=>"Whatsapp",'id'=>"whatsapp",'placeholder'=>"whastapp for confirmation",'required'=>true],         
        ]])      
      </div>
      <br />
    </div>
</div>
<br/>

