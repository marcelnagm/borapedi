<div class="card-content border-top" style="display: none;">
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
    
                    $("#phone").mask("(00) 00000-0000");            
    $(document).ready(function ($) {
                    $("#phone").blur(function () {
//                  alert('mudou');
                        $("#phone_send").val($("#phone").val());
                    });
                });


</script>