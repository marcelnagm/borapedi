<?php

namespace App\Http\Controllers;

use App\Repositories\Orders\OrderRepoGenerator;
use App\Exports\OrdersExport;
use App\Notifications\OrderNotification;
use App\Order;
use App\Restorant;
use App\Status;
use App\User;
use App\Coupons;
use App\WhatsappService as WhatsappService;
use App\Models\Variants;
use App\Models\Extras;
use App\Models\FidelityProgram;
use App\Models\Reward;
use App\Models\RestorantHasDrivers;
use App\Models\OrderHasItems;
use App\Models\ClientRatings;
use App\Models\ClientHasRating;
use App\Items;
use App\WhastappService as WhastappService;
use Carbon\Carbon;
use Cart;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use willvincent\Rateable\Rating;
use App\Services\ConfChanger;
use Akaunting\Module\Facade as Module;
use App\Events\OrderAcceptedByAdmin;
use App\Events\OrderAcceptedByVendor;

class OrderController extends Controller {

    public function migrateStatuses() {
        if (Status::count() < 13) {
            $statuses = ['Just created', 'Accepted by admin', 'Accepted by restaurant', 'Assigned to driver', 'Prepared', 'Picked up', 'Delivered', 'Rejected by admin', 'Rejected by restaurant', 'Updated', 'Closed', 'Rejected by driver', 'Accepted by driver'];
            foreach ($statuses as $key => $status) {
                Status::updateOrCreate(['name' => $status], ['alias' => str_replace(' ', '_', strtolower($status))]);
            }
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $this->migrateStatuses();

        $restorants = Restorant::where(['active' => 1])->get();
        $drivers = User::role('driver')->where(['active' => 1])->get();
        $clients = User::role('client')->where(['active' => 1])->get();
        $driversData = [];

        if (auth()->user()->hasRole('admin')) {

            $drivers = User::role('driver')->paginate(15);
            $driversData = [];
            foreach ($drivers as $key => $driver) {
                $driversData[$driver->id] = $driver->name;
            }
        }
        if (auth()->user()->plan()->first() != null) {
            if (auth()->user()->plan()->first()->driver_own) {
                $drivers = array();
                foreach (RestorantHasDrivers::where('restorant_id', auth()->user()->restorant->id)->pluck('driver_id')->toArray() as $id => $val) {
                    $drivers[] = $val;
                }

//            dd($drivers);
                $drivers = User::select('users.*')
                        ->whereIn('id', $drivers)
                        ->paginate(10);
                $driversData = [];
                foreach ($drivers as $key => $driver) {
                    $driversData[$driver->id] = $driver->name;
                }
            }
        }
        $clients = User::role('client')->where(['active' => 1])->get();




        $orders = Order::orderBy('created_at', 'desc');

        //Get client's orders
        if (auth()->user()->hasRole('client')) {
            $orders = $orders->where(['client_id' => auth()->user()->id]);
            ////Get driver's orders
        } elseif (auth()->user()->hasRole('driver')) {
            $orders = $orders->where(['driver_id' => auth()->user()->id]);
            //Get owner's restorant orders
        } elseif (auth()->user()->hasRole('owner')) {

            //Change currency
            ConfChanger::switchCurrency(auth()->user()->restorant);

            $orders = $orders->where(['restorant_id' => auth()->user()->restorant->id]);
        }

        //FILTER BT RESTORANT
        if (isset($_GET['restorant_id'])) {
            $orders = $orders->where(['restorant_id' => $_GET['restorant_id']]);
        }
        //If restorant owner, get his restorant orders only
        if (auth()->user()->hasRole('owner')) {
            //Current restorant id
            $restorant_id = auth()->user()->restorant->id;
            $orders = $orders->where(['restorant_id' => $restorant_id]);
        }

        //BY CLIENT
        if (isset($_GET['client_id'])) {
            $orders = $orders->where(['client_id' => $_GET['client_id']]);
        }

        //BY DRIVER
        if (isset($_GET['driver_id'])) {
            $orders = $orders->where(['driver_id' => $_GET['driver_id']]);
        }

        //BY DATE FROM
        if (isset($_GET['fromDate']) && strlen($_GET['fromDate']) > 3) {
            //$start = Carbon::parse($_GET['fromDate']);
            $orders = $orders->whereDate('created_at', '>=', $_GET['fromDate']);
        }

        //BY DATE TO
        if (isset($_GET['toDate']) && strlen($_GET['toDate']) > 3) {
            //$end = Carbon::parse($_GET['toDate']);
            $orders = $orders->whereDate('created_at', '<=', $_GET['toDate']);
        }

        //With downloaod
        if (isset($_GET['report'])) {
            $items = [];
            foreach ($orders->get() as $key => $order) {
                $item = [
                    'order_id' => $order->id,
                    'restaurant_name' => $order->restorant->name,
                    'restaurant_id' => $order->restorant_id,
                    'created' => $order->created_at,
                    'last_status' => $order->status->pluck('alias')->last(),
                    'client_name' => $order->client ? $order->client->name : '',
                    'client_id' => $order->client ? $order->client_id : null,
                    'table_name' => $order->table ? $order->table->name : '',
                    'table_id' => $order->table ? $order->table_id : null,
                    'area_name' => $order->table && $order->table->restoarea ? $order->table->restoarea->name : '',
                    'area_id' => $order->table && $order->table->restoarea ? $order->table->restoarea->id : null,
                    'address' => $order->address ? $order->address->address : '',
                    'address_id' => $order->address_id,
                    'driver_name' => $order->driver ? $order->driver->name : '',
                    'driver_id' => $order->driver_id,
                    'order_value' => $order->order_price,
                    'order_delivery' => $order->delivery_price,
                    'order_total' => $order->delivery_price + $order->order_price,
                    'payment_method' => $order->payment_method,
                    'srtipe_payment_id' => $order->srtipe_payment_id,
                    'order_fee' => $order->fee_value,
                    'restaurant_fee' => $order->fee,
                    'restaurant_static_fee' => $order->static_fee,
                    'vat' => $order->vatvalue,
                ];
                array_push($items, $item);
            }

            return Excel::download(new OrdersExport($items), 'orders_' . time() . '.xlsx');
        }

        $orders = $orders->paginate(10);

        return view('orders.index', [
            'orders' => $orders,
            'restorants' => $restorants,
            'drivers' => $drivers,
            'fields' => [['class' => 'col-12', 'classselect' => 'noselecttwo', 'ftype' => 'select', 'name' => 'Driver', 'id' => 'driver', 'placeholder' => 'Assign Driver', 'data' => $driversData, 'required' => true]],
            'clients' => $clients,
            'parameters' => count($_GET) != 0,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        
    }

    private function toMobileLike(Request $request) {
        /* {
          "restaurant_id":1,
          "delivery_method":"delivery", //delivery, pickup, dinein
          "payment_method":"cod" ,
          "address_id":1,
          "platform":"WebService",
          "items":[{
          "id":1,
          "qty":2,
          "extrasSelected":[{"id":1},{"id":2}],
          "variant":1
          }],
          "order_price":72,
          "comment":"",
          "timeslot":"1320_1350",
          "stripe_token":null
          } */


        //Find vendor id
        $vendor_id = null;
        foreach (Cart::getContent() as $key => $item) {
            $vendor_id = $item->attributes->restorant_id;
        }
        $restorant = Restorant::findOrFail($vendor_id);

        //Organize the item
        $items = [];
        foreach (Cart::getContent() as $key => $item) {
            $extras = [];
            foreach ($item->attributes->extras as $keyExtra => $extra_id) {
                array_push($extras, array('id' => $extra_id));
            }
            array_push($items, array(
                "id" => $item->attributes->id,
                "qty" => $item->quantity,
                "variant" => $item->attributes->variant,
                "extrasSelected" => $extras
            ));
        }


        //stripe token
        $stripe_token = null;
        if ($request->has('stripePaymentId')) {
            $stripe_token = $request->stripePaymentId;
        }

        //Custom fields
        $customFields = [];
        if ($request->has('custom')) {
            $customFields = $request->custom;
        }




        //DELIVERY METHOD
        //Default - pickup - since available everywhere
        $delivery_method = "pickup";

        //Delivery method - deliveryType - ft
        if ($request->has('deliveryType')) {
            $delivery_method = $request->deliveryType;
        } else if ($restorant->can_pickup == 0 && $restorant->can_deliver == 1) {
            $delivery_method = "delivery";
        }

        //Delivery method  - dineType - qr
        if ($request->has('dineType')) {
            $delivery_method = $request->dineType;
        }



        //In case it is QR, and there is no dineInType, and pickup is diabled, it is dine in
        if (config('app.isqrsaas') && !$request->has('dineType') && !config('settings.is_whatsapp_ordering_mode')) {
            $delivery_method = 'dinein';
        }
        //takeaway is pickup
        if ($delivery_method == "takeaway") {
            $delivery_method = "pickup";
        }

        //Table id
        $table_id = null;
        if ($request->has('table_id')) {
            $table_id = $request->table_id;
        }

        //Phone 
        $phone = null;
        if ($request->has('phone')) {
            $phone = $request->phone;
        }

        //Delivery area
        $deliveryAreaId = $request->has('delivery_area') ? $request->delivery_area : null;

        $requestData = [
            'vendor_id' => $vendor_id,
            'delivery_method' => $delivery_method,
            'payment_method' => $request->paymentType ? $request->paymentType : "cod",
            'address_id' => $request->addressID,
            "timeslot" => $request->timeslot,
            "money_change" => $request->money_change,
            "items" => $items,
            "comment" => $request->comment,
            "stripe_token" => $stripe_token,
            "dinein_table_id" => $table_id,
            "phone" => $phone,
            "customFields" => $customFields,
            "deliveryAreaId" => $deliveryAreaId
        ];



        return new Request($requestData);
    }

    public function store(Request $request) {

        if (auth()->user()->phone == "") {
            $user = User::find(auth()->user()->id);
            $user->phone = $request->phone_send;
            $user->save();
        }
        if (auth()->user()->email == "") {
            $user = User::find(auth()->user()->id);
            $user->email = $request->email;
            $user->save();
        }
        if (auth()->user()->name == "") {
            $user = User::find(auth()->user()->id);
            $user->name = $request->name;
            $user->save();
        }

//        dd($request);        
        //Convert web request to mobile like request
        $mobileLikeRequest = $this->toMobileLike($request);

        //Data
        $vendor_id = $mobileLikeRequest->vendor_id;
        $expedition = $mobileLikeRequest->delivery_method;
        $hasPayment = ($mobileLikeRequest->payment_method != "cod" || $mobileLikeRequest->payment_method != "card");
        $isStripe = $mobileLikeRequest->payment_method == "stripe";

        $vendorHasOwnPayment = null;
        if (config('settings.social_mode')) {
            //Find the vendor, and check if he has payment

            $vendor = Restorant::findOrFail($mobileLikeRequest->vendor_id);

            //Payment methods
            foreach (Module::all() as $key => $module) {
                if ($module->get('isPaymentModule')) {
                    if ($vendor->getConfig($module->get('alias') . "_enable", "false") == "true") {
                        $vendorHasOwnPayment = $module->get('alias');
                    }
                }
            }

            if ($vendorHasOwnPayment == null) {
                $hasPayment = false;
            }
        }

        //Repo Holder
        $orderRepo = OrderRepoGenerator::makeOrderRepo($vendor_id, $mobileLikeRequest, $expedition, $hasPayment, $isStripe, false, $vendorHasOwnPayment);

        //Proceed with validating the data
        $validator = $orderRepo->validateData();
        if ($validator->fails()) {
            notify()->error($validator->errors()->first());
            return $orderRepo->redirectOrInform();
        }

        //Proceed with making the order
        $validatorOnMaking = $orderRepo->makeOrder();
        if ($validatorOnMaking->fails()) {
            notify()->error($validatorOnMaking->errors()->first());
            return $orderRepo->redirectOrInform();
        }

        return $orderRepo->redirectOrInform();
    }

    public function orderLocationAPI(Order $order) {
        if ($order->status->pluck('alias')->last() == 'picked_up') {
            return response()->json(
                            [
                                'status' => 'tracing',
                                'lat' => $order->lat,
                                'lng' => $order->lng,
                            ]
            );
        } else {
            //return null
            return response()->json(['status' => 'not_tracing']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order) {
        //Do we have pdf invoice
        $pdFInvoice = Module::has('pdf-invoice');

        //Change currency
        ConfChanger::switchCurrency($order->restorant);

        //Change language
        ConfChanger::switchLanguage($order->restorant);

        $drivers = User::role('driver')->get();
        $driversData = [];
        foreach ($drivers as $key => $driver) {
            $driversData[$driver->id] = $driver->name;
        }

        if (auth()->user()->hasRole('client') && auth()->user()->id == $order->client_id ||
                auth()->user()->hasRole('owner') && auth()->user()->id == $order->restorant->user->id ||
                auth()->user()->hasRole('driver') && auth()->user()->id == $order->driver_id || auth()->user()->hasRole('admin')
        ) {
            return view('orders.show', [
                'order' => $order,
                'pdFInvoice' => $pdFInvoice,
                'custom_data' => $order->getAllConfigs(),
                'statuses' => Status::pluck('name', 'id'),
                'drivers' => $drivers,
                'fields' => [['class' => 'col-12', 'classselect' => 'noselecttwo', 'ftype' => 'select', 'name' => 'Driver', 'id' => 'driver', 'placeholder' => 'Assign Driver', 'data' => $driversData, 'required' => true]],
            ]);
        } else {
            return redirect()->route('orders.index')->withStatus(__('No Access.'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function active() {
//       
        $order = Order::where("client_id", auth()->user()->id)->
                        orderBy('created_at', 'DESC')->first();
//          dd($order->status()->count());
//         $order = Order::where("id",10)->
//                 orderBy('created_at', 'DESC')->first();
//          dd($order->laststatus()->first()->id);
        if ($order != null) {
            if ($order->laststatus()->first()->id >= 6 && $order->laststatus()->first()->id <= 11) {
//           pedido concluido e volta para o ultimo restaurante   
                return redirect('/restaurant/' . $order->restorant()->first()->subdomain);
            }
            if ($order->laststatus()->first()->id < 6) {
//           pedido nao concluido
                return redirect()->route('orders.show', ['order' => $order->id]);
            }
        } else {
            return redirect()->route('home');
        }
    }

    public function change($id, $method) {
        $order = Order::findOrFail($id);
        $order->payment_method = $method;
        $order->payment_link = NULL;
        $order->save();
        return redirect()->route('orders.show', ['order' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
        $order = Order::findOrFail($id);
        $restorant = $order->restorant()->first();
        $order->delete();
        return redirect('/restaurant/' . $restorant->subdomain)->withStatus("Pedido cancelado com sucesso");
    }

    public function liveapi() {

        //TODO - Method not allowed for client or driver
        if (auth()->user()->hasRole('client')) {
            dd('Not allowed as client');
        }

        //Today only
        $orders = Order::where('created_at', '>=', Carbon::today())->orderBy('created_at', 'desc');

        //If owner, only from his restorant
        if (auth()->user()->hasRole('owner')) {
            $orders = $orders->where(['restorant_id' => auth()->user()->restorant->id]);

            //Change currency
            ConfChanger::switchCurrency(auth()->user()->restorant);

            //Change language
            //ConfChanger::switchLanguage($order->restorant);
        }
        $orders = $orders->with(['status', 'client', 'restorant', 'table.restoarea'])->get()->toArray();



        $newOrders = [];
        $acceptedOrders = [];
        $doneOrders = [];

        $items = [];
        foreach ($orders as $key => $order) {
            $client = "";
            if (config('app.isft')) {
                $client = $order['client']['name'];
            } else {
                if (!config('settings.is_whatsapp_ordering_mode')) {
                    //QR
                    if ($order['table'] && $order['table']['restoarea'] && $order['table']['restoarea']['name'] && $order['table']['name']) {
                        $client = $order['table']['restoarea']['name'] . ' - ' . $order['table']['name'];
                    } else if ($order['table'] && $order['table']['name']) {
                        $client = $order['table']['name'];
                    }
                } else {
                    //WhatsApp
                    $client = $order['phone'];
                }
            }
            array_push($items, [
                'id' => $order['id'],
                'restaurant_name' => $order['restorant']['name'],
                'last_status' => count($order['status']) > 0 ? __($order['status'][count($order['status']) - 1]['name']) : 'Just created',
                'last_status_id' => count($order['status']) > 0 ? $order['status'][count($order['status']) - 1]['pivot']['status_id'] : 1,
                'time' => $order['updated_at'],
                'client' => $client,
                'link' => '/orders/' . $order['id'],
                'price' => money($order['order_price'], config('settings.cashier_currency'), config('settings.do_convertion')) . '',
            ]);
        }

        //dd($items);

        /**

         */
        //----- ADMIN ------
        if (auth()->user()->hasRole('admin')) {
            foreach ($items as $key => $item) {
                //Box 1 - New Orders
                //Today orders that are just created ( Needs approvment or rejection )
                //Box 2 - Accepted
                //Today orders approved by Restaurant , or by admin( Needs assign to driver )
                //Box 3 - Done
                //Today orders assigned with driver, or rejected
                if ($item['last_status_id'] == 1) {
                    $item['pulse'] = 'blob green';
                    array_push($newOrders, $item);
                } elseif ($item['last_status_id'] == 2 || $item['last_status_id'] == 3) {
                    $item['pulse'] = 'blob orangestatic';
                    if ($item['last_status_id'] == 3) {
                        $item['pulse'] = 'blob orange';
                    }
                    array_push($acceptedOrders, $item);
                } elseif ($item['last_status_id'] > 3) {
                    $item['pulse'] = 'blob greenstatic';
                    if ($item['last_status_id'] == 9 || $item['last_status_id'] == 8) {
                        $item['pulse'] = 'blob redstatic';
                    }
                    array_push($doneOrders, $item);
                }
            }
        }

        //----- Restaurant ------
        if (auth()->user()->hasRole('owner')) {
            foreach ($items as $key => $item) {


                //Box 1 - New Orders
                //Today orders that are approved by admin ( Needs approvment or rejection )
                //Box 2 - Accepted
                //Today orders approved by Restaurant ( Needs change of status to done )
                //Box 3 - Done
                //Today completed or rejected
                $last_status = $item['last_status_id'];
                if ($last_status == 2 || $last_status == 10 || ($item['last_status_id'] == 1 )) {
                    $item['pulse'] = 'blob green';
                    array_push($newOrders, $item);
                } elseif ($last_status == 3 || $last_status == 4 || $last_status == 5) {
                    $item['pulse'] = 'blob orangestatic';
                    if ($last_status == 3) {
                        $item['pulse'] = 'blob orange';
                    }
                    array_push($acceptedOrders, $item);
                } elseif ($last_status > 5 && $last_status != 8) {
                    $item['pulse'] = 'blob greenstatic';
                    if ($last_status == 9 || $last_status == 8) {
                        $item['pulse'] = 'blob redstatic';
                    }
                    array_push($doneOrders, $item);
                }
            }
        }

        $toRespond = [
            'neworders' => $newOrders,
            'accepted' => $acceptedOrders,
            'done' => $doneOrders,
        ];

        return response()->json($toRespond);
    }

    public function live() {
        return view('orders.live');
    }

    public function autoAssignToDriver(Order $order) {
        //The restaurant id
        $restaurant_id = $order->restorant_id;

        //1. Get all the working drivers, where active and working
        $theQuery = User::role('driver')->where(['active' => 1, 'working' => 1]);

        //2. Get Drivers with their assigned order, where payment_status is unpaid yet, this order is still not delivered and not more than 1
        $theQuery = $theQuery->whereHas('driverorders', function (Builder $query) {
            $query->where('payment_status', '!=', 'paid')->where('created_at', '>=', Carbon::today());
        }, '<=', 1);

        //Get Restaurant lat / lng
        $restaurant = Restorant::findOrFail($restaurant_id);
        $lat = $restaurant->lat;
        $lng = $restaurant->lng;

        //3. Sort drivers by distance from the restaurant
        $driversWithGeoIDS = $this->scopeIsWithinMaxDistance($theQuery, $lat, $lng, config('settings.driver_search_radius'), 'users')->pluck('id')->toArray();

        //4. The top driver gets the order
        if (count($driversWithGeoIDS) == 0) {
            //No driver found -- this will appear in  the admin list also in the list of free order so driver can get an order
            //dd('no driver found');
        } else {
            //Driver found
            ///dd('driver found: '.$driversWithGeoIDS[0]);
            $order->driver_id = $driversWithGeoIDS[0];
            $order->update();
            $order->status()->attach([4 => ['comment' => 'System', 'user_id' => $driversWithGeoIDS[0]]]);

            //Now increment the driver orders
            $theDriver = User::findOrFail($order->driver_id);
            $theDriver->numorders = $theDriver->numorders + 1;
            $theDriver->update();
        }
    }

    public function updateStatus($alias, Order $order) {
        if ($alias == 'rebuy') {
            $list = OrderHasItems::where('order_id', $order->id)->get();
//            dd($list[0]->item()->id,$list[1]->item()->id);
            $i = 0;
            foreach ($list as $item_k) {
//            dd($item_k);
                $item = $item_k->item();
                $i++;
                $restID = $item->category->restorant->id;
                $cartItemPrice = $item->price;
                $cartItemName = $item->name;
                $theElement = '';
                //                vartiant
                if ($item_k->variant_name != '') {
                    $res = explode(',', $item_k->variant_name);
                    $variant = Variants::
                            where('item_id', '=', $item->id);
                    foreach ($res as $val) {
                        $variant = $variant->where('options', 'like', "%" . $val . "%");
                    }
                    $variant = $variant->first();
                    if ($variant->item->id == $item->id) {
                        $cartItemPrice = $variant->price;

                        //For each option, find the option on the
                        $cartItemName = $item->name . ' ' . $variant->optionsList;
                        //$theElement.=$value." -- ".$item->extras()->findOrFail($value)->name."  --> ". $cartItemPrice." ->- ";
                        $variant = $variant->id;
                    } else
                        $variant = '';
                } else
                    $variant = '';
//                fim variant                
//                Exctras    
                if ($item_k->extras != '[]') {
                    $res = explode(',', str_replace(']', '', str_replace('[', '', str_replace('"', '', $item_k->extras))));
//                    dd($res);
                    foreach ($res as $key => $value) {
                        $extras = explode('+', $value);
                        $extra = Extras::where('item_id', '=', $item->id)->
                                        where('name', '=', $extras[0])->first();
//                         dd($extra);

                        $cartItemName .= "\n+ " . $extra->name;
                        $cartItemPrice += $extra->price;
                        $theElement .= $extra->name . ' -- ' . $extra->name . '  --> ' . $cartItemPrice . ' ->- ';
                    }
                }
//                fim Exctras                
//                dd($item_k->item_id);

                Cart::add((new \DateTime())->getTimestamp() + $i, $cartItemName, $cartItemPrice, $item_k->qty, ['id' => $item_k->id, 'variant' => $variant, 'extras' => $item_k->extras, 'restorant_id' => $restID, 'image' => $item->icon, 'friendly_price' => Money($cartItemPrice, config('settings.cashier_currency'), config('settings.do_convertion'))->format()]);
                unset($item);
            }

            session(['in_cart' => true]);
            return redirect()->route('cart.checkout')->withStatus('Carrinho remontado finalize!');
        }


        if (isset($_GET['driver'])) {
            $order->driver_id = $_GET['driver'];
            $order->update();

            //Now increment the driver orders
            $theDriver = User::findOrFail($order->driver_id);
            $theDriver->numorders = $theDriver->numorders + 1;
            $theDriver->update();
        }

        if (isset($_GET['time_to_prepare'])) {
            $order->time_to_prepare = $_GET['time_to_prepare'];
            $order->update();
        }

        $status_id_to_attach = Status::where('alias', $alias)->value('id');

        //Check access before updating
        /**
         * 1 - Super Admin
         * accepted_by_admin
         * assigned_to_driver
         * rejected_by_admin.
         *
         * 2 - Restaurant
         * accepted_by_restaurant - 3
         * prepared
         * rejected_by_restaurant
         * picked_up
         * delivered
         *
         * 3 - Driver
         * picked_up
         * delivered
         */
        //

        $rolesNeeded = [
            'accepted_by_admin' => 'admin',
            'assigned_to_driver' => 'admin',
            'rejected_by_admin' => 'admin',
            'accepted_by_restaurant' => 'owner',
            'prepared' => 'owner',
            'rejected_by_restaurant' => 'owner',
            'picked_up' => ['driver', 'owner'],
            'delivered' => ['driver', 'owner'],
            'closed' => 'owner',
            'accepted_by_driver' => ['driver'],
            'rejected_by_driver' => ['driver']
        ];

        if (!auth()->user()->hasRole($rolesNeeded[$alias])) {
            abort(403, 'Unauthorized action. You do not have the appropriate role');
        }

        //For owner - make sure this is his order
        if (auth()->user()->hasRole('owner')) {
            //This user is owner, but we must check if this is order from his restaurant
            if (auth()->user()->id != $order->restorant->user_id) {
                abort(403, 'Unauthorized action. You are not owner of this order restaurant');
            }
        }

        //For driver - make sure he is assigned to this order
        if (auth()->user()->hasRole('driver')) {
            //This user is owner, but we must check if this is order from his restaurant
            if (auth()->user()->id != $order->driver->id) {
                abort(403, 'Unauthorized action. You are not driver of this order');
            }
        }

        /**
         * IF status
         * Accept  - 3
         * Prepared  - 5
         * Rejected - 9.
         */
        // dd($status_id_to_attach."");

        if (config('app.isft')) {
            if ($status_id_to_attach . '' == '3' || $status_id_to_attach . '' == '5' || $status_id_to_attach . '' == '9') {
                try{
                $order->client->notify(new OrderNotification($order, $status_id_to_attach));
                }catch (\Swift_TransportException $ex){
                    
                }
            }

            if ($status_id_to_attach . '' == '4') {
                try{
                $order->driver->notify(new OrderNotification($order, $status_id_to_attach));
                }catch (\Swift_TransportException $ex){
                    
                }
            }
        }
        //decremet coupon id
        if ($status_id_to_attach . '' == '3') {
            $coupon =  $order->coupom()->first();
            if($coupon != null){
              $coupon->decrement('limit_to_num_uses');
            $coupon->increment('used_count');
            $coupon->save();
            }

        }
        //Picked up - start tracing
        if ($status_id_to_attach . '' == '6') {
            $order->lat = $order->restorant->lat;
            $order->lng = $order->restorant->lng;
//            WhatsappService::ssendMessage($order,6);
            $order->update();
        }

        if (config('app.isft') && $alias . '' == 'delivered') {
            $order->payment_status = 'paid';
            $order->update();
//            WhatsappService::sendMessage($order,7);
        }

        if (config('app.isqrsaas') && $alias . '' == 'closed') {
            $order->payment_status = 'paid';
            $order->update();
//            WhatsappService::sendMessage($order,11);
        }

        if (config('app.isft')) {
            //When orders is accepted by restaurant, auto assign to driver
            if ($status_id_to_attach . '' == '3') {
                if (config('settings.allow_automated_assign_to_driver')) {
                    $this->autoAssignToDriver($order);
                }
            }
        }

        //$order->status()->attach([$status->id => ['comment'=>"",'user_id' => auth()->user()->id]]);
        $order->status()->attach([$status_id_to_attach => ['comment' => '', 'user_id' => auth()->user()->id]]);


        //Dispatch event
        if ($alias == "accepted_by_restaurant") {
            OrderAcceptedByVendor::dispatch($order);
        }
        if ($alias == "accepted_by_admin") {
            //IN FT send email
            if (config('app.isft')) {
                try{
                $order->restorant->user->notify((new OrderNotification($order))->locale(strtolower(config('settings.app_locale'))));
                }catch (\Swift_TransportException $ex){
                    
                }
            }

            OrderAcceptedByAdmin::dispatch($order);
        }

        WhastappService::sendMessage($order, $status_id_to_attach);
        return redirect()->route('orders.index')->withStatus(__('Order status succesfully changed.'));
    }

    public function rateOrder(Request $request, Order $order) {
        $restorant = $order->restorant;

        $rating = new Rating;
        $rating->rating = $request->ratingValue;
        $rating->user_id = auth()->user()->id;
        $rating->order_id = $order->id;
        $rating->comment = $request->comment;

        $restorant->ratings()->save($rating);

        return redirect()->route('orders.show', ['order' => $order])->withStatus(__('Order succesfully rated!'));
    }

    public function checkOrderRating(Order $order) {
        $rating = DB::table('ratings')->select('rating')->where(['order_id' => $order->id])->get()->first();
        $is_rated = false;

        if (!empty($rating)) {
            $is_rated = true;
        }

        return response()->json(
                        [
                            'rating' => $rating->rating,
                            'is_rated' => $is_rated,
                        ]
        );
    }

    public function guestOrders() {
        $previousOrders = Cookie::get('orders') ? Cookie::get('orders') : '';
        $previousOrderArray = array_filter(explode(',', $previousOrders));

        //Find the orders
        $orders = Order::whereIn('id', $previousOrderArray)->orderBy('id', 'desc')->get();
        $backUrl = url()->previous();
        foreach ($orders as $key => $order) {
            $backUrl = route('vendor', $order->restorant->subdomain);
        }

        return view('orders.guestorders', ['backUrl' => $backUrl, 'orders' => $orders, 'statuses' => Status::pluck('name', 'id')]);
    }

    public function generateOrderMsg($address, $comment, $price) {
        $title = 'New order #' . strtoupper(Str::random(5)) . "\n\n";

        $price = '*Price*: ' . $price . ' ' . config('settings.cashier_currency') . "\n\n";

        $items = '*Order:*' . "\n";
        foreach (Cart::getContent() as $key => $item) {
            $items .= strval($item->quantity) . ' x ' . $item->name . "\n";
        }
        $items .= "\n";
        $final = $title . $price . $items;

        if ($address != null) {
            $final .= '*Address*:' . "\n" . $address . "\n\n";
        }

        if ($comment != null) {
            $final .= '*Comment:*' . "\n" . $comment . "\n\n";
        }

        return urlencode($final);
    }

    public function fbOrderMsg(Request $request) {
        $orderPrice = Cart::getSubTotal();

        $title = 'New order #' . strtoupper(Str::random(5)) . "\n\n";

        $price = '*Price*: ' . $orderPrice . ' ' . config('settings.cashier_currency') . "\n\n";

        $items = '*Order:*' . "\n";
        foreach (Cart::getContent() as $key => $item) {
            $items .= strval($item->quantity) . ' x ' . $item->name . "\n";
        }
        $items .= "\n";
        $final = $title . $price . $items;

        if ($request->address != null) {
            $final .= '*Address*:' . "\n" . $request->address . "\n\n";
        }

        if ($request->comment != null) {
            $final .= '*Comment:*' . "\n" . $request->comment . "\n\n";
        }

        return response()->json(
                        [
                            'status' => true,
                            'msg' => $final,
                        ]
        );
    }

    public function storeWhatsappOrder(Request $request) {
        $restorant_id = null;
        foreach (Cart::getContent() as $key => $item) {
            $restorant_id = $item->attributes->restorant_id;
        }

        $restorant = Restorant::findOrFail($restorant_id);

        $orderPrice = Cart::getSubTotal();

        if ($request->exists('deliveryType')) {
            $isDelivery = $request->deliveryType == 'delivery';
        }

        $text = $this->generateWhatsappOrder($request->exists('addressID') ? $request->addressID : null, $request->exists('comment') ? $request->comment : null, $orderPrice);

        $url = 'https://wa.me/' . $restorant->whatsapp_phone . '?text=' . $text;

        Cart::clear();

        return Redirect::to($url);
    }

    public function fail(Request $request) {
        $order = Order::findOrFail($request->order);
//        dd( $request['status'] );
//        dd( session('error_payment') );
        return view('orders.fail',
                ['order' => $order,
                    'status' => $request['status'],
        ]);
    }

    public function success(Request $request) {
        $order = Order::findOrFail($request->order);
        WhastappService::sendMessage($order, 1);
           if (session()->exists('coupon_applyed')){
        $order->coupom_id = session('coupon_applyed')->id;
           }
        $order->save();
        session(['coupon_applyed' => null]);
        //If order is not paid - redirect to payment
        if ($request->redirectToPayment . "" == "1" && $order->payment_status != 'paid' && strlen($order->payment_link) > 5) {
            //Redirect to payment
            return redirect($order->payment_link);
        }

        $ratings = ClientRatings::where("restaurant_id", $order->restorant_id)->count();

        $fidelity = FidelityProgram::where("restaurant_id", $order->restorant_id)
                        ->where('active', 1)->first();
//        dd($fidelity);
        if ($fidelity != null) {

            //valor total == 1
            if ($fidelity->type_target == 1) {
                $res = DB::select('SELECT count(client_id) as cont,sum(`order_price`) as total FROM `orders` WHERE `client_id` = ' . auth()->user()->id . ' '
                                . 'and restorant_id = "' . $fidelity->restaurant_id . '" group by client_id');
            } else {
                $res = DB::select('SELECT count(client_id) as cont,sum(`order_price`) as total FROM `orders` WHERE `client_id` = ' . auth()->user()->id . ' '
                                . 'and restorant_id = "' . $fidelity->restaurant_id . '"'
                                . 'and  order_price >= ' . $fidelity->target_value
                                . ' group by client_id');
                
            }
            $res = json_decode(json_encode($res), true);
//            dd($res);
            if (count($res) > 0) {
                $res = $res[0];
                $reward = $fidelity->type_target == 1 ? $fidelity->target_value <= $res['total'] : ($fidelity->target_orders <= $res['cont'] );

//                dd($reward);
//                 dd($buys);
                if ($reward) {
                    if (auth()->user()->fidelity_program_reward($fidelity->id)
                    ) {
                        $reward = new Reward();
                        $reward->program_id = $fidelity->id;
                        $reward->client_id = auth()->user()->id;
                        $reward->save();

                        $date = new \DateTime();
                        $coupon = new Coupons();
                        $coupon->client_id = auth()->user()->id;
                        $coupon->name = '#REWARD - ' . auth()->user()->id;
                        $coupon->code = 'RWD' . (auth()->user()->id) .''.($fidelity->restaurant_id);
                        $coupon->restaurant_id = $fidelity->restaurant_id;
                        $coupon->type = $fidelity->type_coupon;
                        $coupon->price = $fidelity->reward;
                        $coupon->limit_to_num_uses = 1;
                        $coupon->limit_to_num_uses = 1;
                        $coupon->active_from = $date;
                        $coupon->active_to = date('Y-m-d', strtotime(date('Y-m-d') . ' +  3 month'));                        
                        $coupon->save();
                        
//                        dd (WhastappService::generateTextReward($coupon));
                        WhastappService::sendMessageReward($order, $coupon);
        
//                    dd("maior");
                    } else {
//                    dd('Ja recebeuy');
                    }
                }
            }
        }

//        FidelityProgram
////       se possui fidelizacao
        if ($ratings > 0) {
            $my_ranting = auth()->user()->client_has_rating($order->restorant_id)->first();
            if ($my_ranting == NULL) {
//                dd(" no rating ");
                $my_ranting = new ClientHasRating();
                $my_ranting->restaurant_id = $order->restorant_id;
                $my_ranting->client_id = auth()->user()->id;
                $my_ranting->rating_id = null;
            }

//                   dd($my_ranting->client_id);
            $max = DB::select('SELECT max(period) as max FROM `clients_ratings` WHERE `restaurant_id` = ' . $order->restorant_id)[0];
            $max = json_decode(json_encode($max), true);
//            dd($max);
            $date = date('Y-m-d', strtotime(date('Y-m-d') . ' - ' . $max['max'] . ' month'));
//            dd($date);
            $res = DB::select('SELECT count(client_id) as cont,sum(`order_price`) as total FROM `orders` WHERE `client_id` = ' . auth()->user()->id . ' and created_at >= "' . $date . '" and restorant_id = "' . $order->restorant_id . '" group by client_id');
            $res = json_decode(json_encode($res), true);
            if (count($res) > 0) {
                $res = $res[0];
//            dd($res);
                $my_ranting->orders = $res['cont'];
                $my_ranting->spent = $res['total'];
            } else {
                $my_ranting->orders = 0;
                $my_ranting->spent = 0;
            }
            $rating = ClientRatings::select("clients_ratings.*")->where("restaurant_id", $order->restorant_id)->
                            where("clients_ratings.val", "<=", $my_ranting->spent)
                            ->orderby("clients_ratings.val", "desc")->first();

//            dd($rating->name);
            $my_ranting->rating_id = $rating->id;
            $my_ranting->save();
//            dd(" have r ating ");
        }
        //If we have whatsapp send
        if ($request->has('whatsapp')) {
            $message = $order->getSocialMessageAttribute(true);
            $url = 'https://api.whatsapp.com/send?phone=' . $order->restorant->whatsapp_phone . '&text=' . $message;
            return Redirect::to($url);
        }

        //Should we show whatsapp send order
        $showWhatsApp = config('settings.whatsapp_ordering_enabled');

        if ($showWhatsApp) {
            //Disable when WhatsApp Mode
            if (config('settings.is_whatsapp_ordering_mode')) {
                $showWhatsApp = false;
            }

            //In QR, if owner phone is not set, hide the button
            //In FT, we use owner phone to have the number
            if (strlen($order->restorant->whatsapp_phone) < 3) {
                $showWhatsApp = false;
            }
        }


        return view('orders.success', ['order' => $order, 'showWhatsApp' => $showWhatsApp]);
    }

}
