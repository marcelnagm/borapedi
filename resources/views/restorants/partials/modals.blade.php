<div class="modal fade" id="productModal" z-index="9999" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-" role="document" id="modalDialogItem">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="modalTitle" class="modal-title" id="modal-title-new-item"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <div class="card shadow border-0">
                    <div class="card-body px-lg-5 py-lg-5">
                        <div class="row">
                            <div class="col-sm col-md col-lg text-center" id="modalImgPart">
                                <img id="modalImg" src="" width="295px" height="200px">
                            </div>
                            <div class="col-sm col-md col-lg col-lg" id="modalItemDetailsPart">
                                <input id="modalID" type="hidden"></input>
                                <span id="modalPrice" class="new-price"></span>
                                <p id="modalDescription"></p>
                                <div id="variants-area">
                                    <label class="form-control-label">{{ __('Select your options') }}</label>
                                    <div id="variants-area-inside">
                                    </div>
                                </div>
                                <div id="exrtas-area">
                                    <br />
                                    <label class="form-control-label" for="quantity">{{ __('Extras') }}</label>
                                    <div id="exrtas-area-inside">
                                    </div>
                                </div>
                                @if(  !(isset($canDoOrdering)&&!$canDoOrdering)   )
                                <div class="quantity-area">
                                    <div class="form-group">
                                        <br />
                                        <label class="form-control-label" for="quantity">{{ __('Quantity') }}</label>
                                        <!--<input type="number" name="quantity" id="quantity" class="form-control form-control-alternative" placeholder="1" value="1" required autofocus>-->
                                        <input
                                            type="number"
                                            min="1"
                                            step="1"
                                            onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                            name="quantity" 
                                            id="quantity" 
                                            class="form-control form-control-alternative" 
                                            placeholder="1" 
                                            value="1" 
                                            required 
                                            autofocus
                                            >
                                    </div>
                                    <div class="quantity-btn">
                                        <div id="addToCart1">
                                            <button class="btn btn-primary" v-on:click='addToCartAct'>{{ __('Add To Cart') }}</button>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-import-restaurants" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-new-item">{{ __('Import restaurants from CSV') }}</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <div class="card bg-secondary shadow border-0">
                    <div class="card-body px-lg-5 py-lg-5">
                        <div class="col-md-10 offset-md-1">
                            <form role="form" method="post" action="{{ route('import.restaurants') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group text-center{{ $errors->has('item_image') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="resto_excel">Import your file</label>
                                    <div class="text-center">
                                        <input type="file" class="form-control form-control-file" name="resto_excel" accept=".csv, .ods, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required>
                                    </div>
                                </div>
                                <input name="category_id" id="category_id" type="hidden" required>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary my-4">{{ __('Save') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@isset($restorant)
<div class="modal fade" id="modal-restaurant-info" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document" >
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="card">
                    <div class="card-header bg-white text-center">
                        <img class="img-center" src="{{ $restorant->icon }}" width="100px" height="100px"></img>
                        <h3 class="headihng mt-4">{{ $restorant->name }} &nbsp;@if(count($restorant->ratings))<span><i class="fa fa-star" style="color: #dc3545"></i> <strong>{{ number_format($restorant->averageRating, 1, '.', ',') }} <span class="small">/ 5 ({{ count($restorant->ratings) }})</strong></span></span>@endif</h3>
                        <h5 class="description">{{ $restorant->description }}</h5>
                        @if(!empty($openingTime) && !empty($closingTime))
                        <p class="description">{{ __('Open') }}: {{ $openingTime }} - {{ $closingTime }}</p>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="nav-wrapper">
                            <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="tabs-icons-text" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link mb-sm-3 mb-md-0 active" id="tabs-icons-text-1-tab" data-toggle="tab" href="#tabs-icons-text-1" role="tab" aria-controls="tabs-icons-text-1" aria-selected="true">{{ __('About') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-2-tab" data-toggle="tab" href="#tabs-icons-text-2" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false">{{ __('Reviews') }}</a>
                                </li>
                                @if($restorant->fidelity_program()!= null)
                                <li class="nav-item">
                                    <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-3-tab" data-toggle="tab" href="#tabs-icons-text-3" role="tab" aria-controls="tabs-icons-text-3" aria-selected="false">Programa de Fidelidade</a>
                                </li>
                                @endif
                            </ul>
                        </div>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="heading-small">Telefone</h6>
                                        <p class="heading-small text-muted"><a href="tel://{{ $restorant->phone }}">{{ $restorant->phone }}</a></p>
                                        <br/>
                                        <h6 class="heading-small">Whatsapp</h6>
                                        <p class="heading-small text-muted"><a href="https://wa.me/{{ $restorant->whatsapp_phone }}">{{ $restorant->whatsapp_phone }}</a></p>
                                        <br/>
                                        <h6 class="heading-small">{{ __('Address') }}</h6>
                                        <p class="heading-small text-muted">{{ $restorant->address }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div id="map3" class="form-control form-control-alternative"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="tabs-icons-text-2" role="tabpanel" aria-labelledby="tabs-icons-text-2-tab">
                                @if(count($restorant->ratings) != 0)
                                <br/>
                                <h5>{{ count($restorant->ratings) }} {{ count($restorant->ratings) == 1 ? __('Review') : __('Reviews')}}</h5>
                                <hr />

                                @foreach($restorant->ratings as $rating)
                                <div class="strip">
                                    <span class="res_title"><b>{{ $rating->user->name }}</b></span><span class="float-right"><i class="fa fa-star" style="color: #dc3545"></i> <strong>{{ number_format($rating->rating, 1, '.', ',') }} <span class="small">/ 5</strong></span></span><br />
                                    <span class="text-muted"> {{ $rating->created_at->format(env('DATETIME_DISPLAY_FORMAT','d M Y')) }}</span><br/>
                                    <br/>
                                    <span class="res_description text-muted">{{ $rating->comment }}</span><br />
                                </div>
                                @endforeach
                                @else
                                <p>{{ __('There are no reviews yet.') }}<p>
                                    @endif
                            </div>
                            @if($restorant->fidelity_program()!= null)
                            <?php $item = $restorant->fidelity_program()?>
                            <div class="tab-pane fade" id="tabs-icons-text-3" role="tabpanel" aria-labelledby="tabs-icons-text-3-tab">
                                <div class="table-responsive">

                                            <table class="table align-items-center table-flush">
                                                <tr>
                                                    <td>Programa de Fidelidade - {{ $item->restorant()->name }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Regras
                                                        <p>
                                                            @if($item->type_target == 0 )
                                                            Ao fazer {{ $item->target_orders }} pedidos de pelo menos R${{ $item->target_value }}  você tem direito ao benefício.
                                                            @else
                                                            Ao fazer R${{ $item->target_value }} em compras no restaurante  você tem direito ao benefício. 
                                                            @endif       
                                                        </p>
                                                    </td>
                                                </tr>
                                                <td>Beneficio:

                                                    <p>
                                                        @if ($item->type_reward == 0)
                                                        Cupom de {{ $item->type_coupon == 0 ? $item->reward." ".config('settings.cashier_currency') : $item->reward." %"}}
                                                        @else
                                                        Nao Disponivel
                                                        @endif
                                                    </p>
                                                </td>
                                                @auth
                                                <tr>
                                                    <td>
                                                        <?php
                                                        $buys = auth()->user()->BuysByRestaurant($item->restorant()->id, 1);

                                                        ?>
                                                        <div class="progress-wrapper">
                                                            <div class="progress-info">
                                                                <div class="progress-label">
                                                                    <span>Progresso:</span>
                                                                    @if($item->type_target == 0 )
                                                                     <?php
                                                        $buys = auth()->user()->BuysByRestaurant($item->restorant()->id, 1);
                                                        ?>
                                                                    {{$buys['cont']}} Feitos / {{$item->target_orders }} Necessãrios 
                                                                    <?php $per = $item->target_orders > $buys['cont'] ? ($buys['cont'] / $item->target_orders) * 100 : 100; ?>
                                                                    @else
                                                                     <?php
                                                        $buys = auth()->user()->BuysByRestaurant($item->restorant()->id, 1,$item->target_value);

                                                        ?>
                                                                    <?php $per = $item->target_value > $buys['total'] ? ($buys['total'] / $item->target_value) * 100 : 100; ?>
                                                                    R${{ $buys['total']}} Comprados / R${{$item->target_value}} Necessãrios 
                                                                    @endif       
                                                                </div>

                                                            </div>
                                                            <div class="progress"  style="width: 300px">
                                                                <div class="progress-bar bg-primary" role="progressbar" aria-valuenow="{{$per}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$per}}%;"></div>

                                                            </div>
                                                            <span>{{number_format($per,2)}}%</span>    
                                                        </div>                                

                                                        </div>

                                                    </td>
                                                </tr>
                                                <tr>                       
                                                    <td>
                                                        Recompensa disponivel: 
                                                        @if(auth()->user()->fidelity_program_reward($item->id))
                                                        Se não houve utilizado ele estará disponivel ao finalizar o pedido
                                                        @else
                                                        Não
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endauth

                                            </table>
                                        </div>
                        </div>
                            @endif
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endisset


