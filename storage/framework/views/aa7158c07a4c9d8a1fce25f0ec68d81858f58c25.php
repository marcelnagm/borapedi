
<script src="<?php echo e(asset('social')); ?>/js/core/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo e(asset('custom')); ?>/js/notify.min.js"></script>
<script>
  function notify(text, type){
        $.notify.addStyle('custom', {
            html: "<div><strong><span data-notify-text /></strong></div>",
            classes: {
                base: {
                    "pos ition": "relative",
                    "margin-bottom": "1rem",
                    "padding": "1rem 1.5rem",
                    "border": "1px solid transparent",
                    "border-radius": ".375rem",

                    "color": "#fff",
                    "border-color": type == "success" ? "#4fd69c" : "#fc7c5f",
                    "background-color": type == "success" ? "#4fd69c" : "#fc7c5f",
                },
                success: {
                    "color": "#fff",
                    "border-color": type == "success" ? "#4fd69c" : "#fc7c5f",
                    "background-color": type == "success" ? "#4fd69c" : "#fc7c5f",
                }
            }
            });

            $.notify(text,{
                position: "top right",
                style: 'custom',
                className: 'success',
                autoHideDelay: 15000
            }
        );
    }
   </script>
<?php if(session('status')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo e(session('status')); ?>

        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<script>
//    alert ('tem');
notify('<?php echo e(session('status')); ?>','success');

   </script>
<?php endif; ?>
<?php if(session('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?php echo e(session('error')); ?>

        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<script>
notify('<?php echo e(session('error')); ?>','error'); 
</script>
<?php endif; ?><?php /**PATH /home/borapedi/public_html/resources/views/partials/flash.blade.php ENDPATH**/ ?>