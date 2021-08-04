<style>
    .modal-content-custom {
   background-color: #ffa200 ;
}
.modal-title-custom{    
    color:white;
}
.modal-header-custom{
    border-bottom: none !important;
}

</style>
    
<div class="modal fade" id="modal-advertise" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document" >        
        <div class="modal-content modal-content-custom ">
            <div class="modal-header modal-header-custom" >
                <h5 class="modal-title modal-title-custom" id="modal-title-notification">Ofertas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>            
            <div class="modal-body p-0">                
                <div class="row blog">
                    <div class="col-lg-12">
                        <div id="blogCarousel" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                @for($i = 0; $i < count($banners); $i++) 
                                <div class="carousel-item @if($i==0) {{'active'}} @endif">
                                    <div class="row">                                          
                                        <div class="col-12">
                                            <div class="card mb-4 mb-xl-0 bg-secondary">
                                                <img src="{{ $banners[$i]->imgm }}"  alt="..."/>
                                            </div>
                                        </div>                                    </div>
                                </div>
                                @endfor
                            </div>
                            <a class="carousel-control-prev" href="#blogCarousel" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only bg-primary">Anterior</span>
                            </a>
                            <a class="carousel-control-next" href="#blogCarousel" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Proximo</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

