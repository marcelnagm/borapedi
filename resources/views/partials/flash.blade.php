
<script src="{{ asset('social') }}/js/core/jquery.min.js" type="text/javascript"></script>
<script src="{{ asset('custom') }}/js/notify.min.js"></script>
<script src="{{ asset('custom') }}/js/notify_custom.js"></script>
@if (session('status'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('status') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<script>
//    alert ('tem');
notify('{{ session('status') }}','success');
   </script>
@endif
@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<script>
notify('{{ session('error') }}','error'); 
</script>
@endif
