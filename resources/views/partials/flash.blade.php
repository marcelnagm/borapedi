@if (session('status'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('status') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</script>
@endif
@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<script src="{{ asset('custom') }}/js/notify.min.js"></script>
<script>
 function notify(text, type){
        self.$notify.addStyle('custom', {
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

            self.$notify.text,{
                position: "bottom right",
                style: 'custom',
                className: 'success',
                autoHideDelay: 5000,
            }
        );
    }
     notify("Pegaa", "success");
   </script>