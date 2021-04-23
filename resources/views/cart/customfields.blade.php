<div class="mt-5">
    <h3>Informação de Cliente<span class="font-weight-light"></span></h3>
</div>
<div class="card-content border-top">
    <br />
    {{auth()->user()->name}}  
    <br />
    <?php if (auth()->user()->phone == "") { ?>
        <script>
            var no_phone = true;
        </script>
        @include('partials.fields',['fields'=>[
        ['ftype'=>'input','name'=>"Whatsapp",'id'=>"phone",'placeholder'=>"Coloque seu Whatsapp aqui ...",'required'=>true],
        ]])

    <?php } else { ?>
        <script>
            var no_phone = false;
        </script>  
        // {{auth()->user()->phone}}
    <?php } ?>
    <br />
</div>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>

<script>
                $(document).ready(function ($) {
                    $("#phone").mask("(00) 00000-0000");
                    $("#phone").blur(function () {
//                  alert('mudou');
                        $("#phone_send").val($("#phone").val());
                    });
                });


</script>