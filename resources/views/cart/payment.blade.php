<div class="card card-profile shadow cart_adapt" >
    <div class="px-4">
        <div class="mt-5">
            <h3>Resumo<span class="font-weight-light"></span></h3>
        </div>
        <div  class="border-top">
            <!-- Price overview -->
            <div id="totalPrices" v-cloak>
                <div class="card card-stats mb-4 mb-xl-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <span v-if="totalPrice==0">{{ __('Cart is empty') }}!</span>

                                <span v-if="totalPrice"><strong>{{ __('Subtotal') }}:</strong></span>
                                <span v-if="totalPrice" class="ammount"><strong>@{{ totalPriceFormat }}</strong></span>
                                @if(config('app.isft'))
                                <span v-if="totalPrice&&delivery"><br />{{ __('Delivery') }}:</span>
                                <span v-if="totalPrice&&delivery" class="ammount" id="deliveryTax">@{{ deliveryPriceFormated }}</span><br />
                                @endif
                                <br />
                                <span v-if="totalPrice"><strong>{{ __('TOTAL') }}:</strong></span>
                                <span v-if="totalPrice" class="ammount"><strong>@{{ withDeliveryFormat   }}</strong></span>
                                <input v-if="totalPrice" type="hidden" id="tootalPricewithDeliveryRaw" :value="withDelivery" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End price overview -->
            @include('cart.coupons')
            <!-- Payment  Methods -->
            <div class="cards">
                <!-- Errors on Stripe -->                            
                </br>
                <!-- COD -->
                @if (!config('settings.hide_cod'))
                <h5>Forma de Pagamento</h5>
                <select id="paymentType" name="paymentType" class="">
                    <option value='' >Selecione uma forma de pagamento</option>
                    <option  class="custom-control-input" id="cashOnDelivery" value='cod' >Pagamento em Dinheiro - Entrega</option>
                    <option class="custom-control-input" id="cardOnDelivery" value='card'>Pagamento no Cartão- Entrega</option>
                    <!-- Extra Payments ( Via module ) -->

                    @if($enablePayments)
                    @foreach ($extraPayments as $extraPayment)
                    @include($extraPayment.'::selector')
                    @endforeach


                    @endif
                </select>

                @endif

                <!--                        
                                             STIPE CART 
                                            @if (config('settings.stripe_key')&&config('settings.enable_stripe'))
                                                <div class="custom-control custom-radio mb-3">
                                                    <input name="paymentType" class="custom-control-input" id="paymentStripe" type="radio" value="stripe" {{ config('settings.default_payment')=="stripe"?"checked":""}}>
                                                    <label class="custom-control-label" for="paymentStripe">{{ __('Pay with card') }}</label>
                                                </div>
                                            @endif-->


            </div>

            <!-- END Payment -->

            <!-- Payment Actions -->

            <!-- COD -->
            @include('cart.payments.cod')

            <!-- Extra Payments ( Via module ) -->
            @foreach ($extraPayments as $extraPayment)
            @include($extraPayment.'::button')
            @endforeach

            </form>


            <!-- END Payment Actions -->

        </div>
    </div>   

    @if (auth()->user()->phone != "")
    <br/>
    <div class="text-center " style="padding:15px 30px 0 30px; background-color: #d9d9d9">
        <div class="custom-control custom-checkbox">
            <input class="custom-control-input" id="privacypolicy" type="checkbox">
            <label class="custom-control-label" for="privacypolicy" style="text-align:  justify;">
                <b > Concordar em receber mensagens do Whatsapp</b>
                <p>Você receberá notificações do estabelecimento por WhatsApp sobre o seu pedido.</p>
            </label>        
        </div>
    </div>
    @endif
</div>

@if(config('settings.is_demo') && config('settings.enable_stripe'))
@include('cart.democards')
@endif