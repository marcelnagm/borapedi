<?php

namespace App\Http\Controllers;

use App\City;
use App\Notifications\DriverCreated;
use App\Order;
use App\Status;
use App\Tables;
use App\User;
use App\Models\RestorantHasDrivers;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class DriverController extends Controller {

    /**
     * Provide class.
     */
    private $provider = User::class;

    /**
     * List of fields for edit and create.
     */
    private function getFields($class = 'col-md-6') {
        $cities = City::where('id', '>', 0)->get();
        $citiesData = [];
        foreach ($cities as $key => $city) {
            $citiesData[$city->id] = $city->name;
        }

        $arr = [
            ['class' => $class, 'ftype' => 'input', 'name' => 'Name', 'id' => 'name', 'placeholder' => __('Driver name'), 'required' => true],
            ['class' => $class, 'ftype' => 'input', 'name' => 'Email', 'id' => 'email', 'placeholder' => __('Driver email'), 'required' => true],
            ['class' => $class, 'ftype' => 'input', 'name' => 'Phone', 'id' => 'phone_number', 'placeholder' => __('Driver phone'), 'required' => true],
        ];

        if (config('settings.multi_city')) {
            array_push($arr, ['class' => $class, 'ftype' => 'select', 'name' => 'City', 'id' => 'city', 'placeholder' => __('Select city'), 'data' => $citiesData, 'required' => true]);
        }

        return $arr;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        if (auth()->user()->hasRole('admin')) {

            $drivers = User::role('driver')->paginate(15);
            return view('drivers.index', ['drivers' => $drivers]);
        } elseif (auth()->user()->plan()->first()->driver_own) {
            $drivers = array();
            foreach (RestorantHasDrivers::where('restorant_id', auth()->user()->restorant->id)->pluck('driver_id')->toArray() as $id => $val) {
                $drivers[] = $val;
            }

//            dd($drivers);
            $drivers = User::select('users.*')
                    ->whereIn('id', $drivers)
                    ->paginate(10);

            return view('drivers.index', ['drivers' => $drivers]);
        } else {
            return redirect()->route('orders.index')->withStatus(__('No Access'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        if (auth()->user()->hasRole('admin') || auth()->user()->plan()->first()->driver_own) {
            return view('drivers.create');
        } else {
            return redirect()->route('orders.index')->withStatus(__('No Access'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //Validate
        $request->validate([
            'name_driver' => ['required', 'string', 'max:255'],
            'email_driver' => ['required', 'string', 'email', 'unique:users,email', 'max:255'],
            'phone_driver' => ['required', 'string', 'regex:/^([0-9\s\-\+\(\)]*)$/'],
        ]);

        //Create the driver
        $generatedPassword = Str::random(10);

        $driver = new User;
        $driver->name = strip_tags($request->name_driver);
        $driver->email = strip_tags($request->email_driver);
        $driver->phone = strip_tags($request->phone_driver);
        $driver->api_token = Str::random(80);
        //$driver->password =  Hash::make(str_random(10));
        $driver->password = Hash::make($generatedPassword);
        $driver->save();

        //Assign role
        $driver->assignRole('driver');
        if (auth()->user()->plan()->first()->driver_own) {
            $link = new RestorantHasDrivers();
            $link->restorant_id = auth()->user()->restorant()->first()->id;
            $link->driver_id = $driver->id;
            $link->save();
        }

        //Send email to the user/driver
        $driver->notify(new DriverCreated($generatedPassword, $driver));

        return redirect()->route('drivers.index')->withStatus(__('Driver successfully created.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function show(User $driver) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function edit(User $driver) {
        //Today paid orders
        $today = Order::where(['driver_id' => $driver->id])->where('payment_status', 'paid')->where('created_at', '>=', Carbon::today());

        //Week paid orders
        $week = Order::where(['driver_id' => $driver->id])->where('payment_status', 'paid')->where('created_at', '>=', Carbon::now()->startOfWeek());

        //This month paid orders
        $month = Order::where(['driver_id' => $driver->id])->where('payment_status', 'paid')->where('created_at', '>=', Carbon::now()->startOfMonth());

        //Previous month paid orders 
        $previousmonth = Order::where(['driver_id' => $driver->id])->where('payment_status', 'paid')->where('created_at', '>=', Carbon::now()->subMonth(1)->startOfMonth())->where('created_at', '<', Carbon::now()->subMonth(1)->endOfMonth());


        //This user driver_percent_from_deliver
        $driver_percent_from_deliver = intval(auth()->user()->getConfig('driver_percent_from_deliver', config('settings.driver_percent_from_deliver'))) / 100;

        $earnings = [
            'today' => [
                'orders' => $today->count(),
                'earning' => $today->sum('delivery_price') * $driver_percent_from_deliver,
                'icon' => 'bg-gradient-red'
            ],
            'week' => [
                'orders' => $week->count(),
                'earning' => $week->sum('delivery_price') * $driver_percent_from_deliver,
                'icon' => 'bg-gradient-orange'
            ],
            'month' => [
                'orders' => $month->count(),
                'earning' => $month->sum('delivery_price') * $driver_percent_from_deliver,
                'icon' => 'bg-gradient-green'
            ],
            'previous' => [
                'orders' => $previousmonth->count(),
                'earning' => $previousmonth->sum('delivery_price') * $driver_percent_from_deliver,
                'icon' => 'bg-gradient-info'
            ]
        ];

        if (auth()->user()->hasRole('admin') || auth()->user()->plan()->first()->driver_own) {

            return view('drivers.edit', [
                'driver' => $driver,
                'earnings' => $earnings
            ]);
            //return view('drivers.edit', compact('driver'));
        } else {
            return redirect()->route('orders.index')->withStatus(__('No Access'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $driver) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $driver) {
        //$driver->delete();
        $driver->active = 0;
        $driver->save();

        return redirect()->route('drivers.index')->withStatus(__('Driver successfully deleted.'));
    }

    public function activateDriver(User $driver) {
        $driver->active = 1;
        $driver->update();

        return redirect()->route('drivers.index')->withStatus(__('Driver successfully activated.'));
    }

    public function register() {
        return view('general.form_front', ['setup' => [
                'inrow' => true,
                'action_link' => null,
                'action_name' => __('crud.back'),
                'title' => __('crud.new_item', ['item' => __('Driver')]),
                'iscontent' => true,
                'action' => route('driver.register.store'),
            ],
            'fields' => $this->getFields('col-md-6'),]);
    }

    public function registerStore(Request $request) {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'unique:users,email', 'max:255'],
            'phone_number' => ['required', 'string', 'regex:/^([0-9\s\-\+\(\)]*)$/'],
        ]);

        $generatedPassword = Str::random(10);

        $driver = $this->provider::create([
                    'name' => strip_tags($request->name),
                    'phone_number' => strip_tags($request->phone_number),
                    'email' => strip_tags($request->email),
                    'api_token' => Str::random(80),
                    'password' => Hash::make($generatedPassword),
        ]);

        $driver->save();

        $driver->assignRole('driver');

        //Send email to the user/driver
        $driver->notify(new DriverCreated($generatedPassword, $driver));

        return redirect()->back()->withStatus(__('notifications_thanks_andcheckemail'));
    }

    public function getToken(Request $request) {
        $user = User::where(['active' => 1, 'email' => $request->email])->first();
        if ($user != null) {
            if (Hash::check($request->password, $user->password)) {
                if ($user->hasRole(['driver'])) {
                    return response()->json([
                                'status' => true,
                                'token' => $user->api_token,
                                'id' => $user->id,
                    ]);
                } else {
                    return response()->json([
                                'status' => false,
                                'errMsg' => 'User is not a driver. Please create driver',
                    ]);
                }
            } else {
                return response()->json([
                            'status' => false,
                            'errMsg' => 'Incorrect password',
                ]);
            }
        } else {
            return response()->json([
                        'status' => false,
                        'errMsg' => 'User not found. Incorrect email.',
            ]);
        }
    }

    public function getOrders() {
        $orders = Order::orderBy('created_at', 'desc');
        $orders = $orders->where(['driver_id' => auth()->user()->id]);
        $orders = $orders->where('created_at', '>=', Carbon::today());

        //TODO -- Today orders only

        return response()->json([
                    'data' => $orders->with(['items', 'status', 'restorant', 'client', 'address'])->get(),
                    'driver_id' => auth()->user()->id,
                    'status' => true,
                    'errMsg' => '',
        ]);
    }

    public function orderTracking(Order $order, $lat, $lng) {
        $order->lat = $lat;
        $order->lng = $lng;
        $order->update();

        return response()->json([
                    'status' => true,
                    'message' => 'Order location updated',
        ]);
    }

    public function updateOrderStatus(Order $order, Status $status) {
        $order->status()->attach($status->id, ['user_id' => auth()->user()->id, 'comment' => isset($_GET['comment']) ? $_GET['comment'] : '']);
        if ($status->id == 6) {
            $order->lat = $order->restorant->lat;
            $order->lng = $order->restorant->lng;
            $order->update();
        }

        if ($status->alias . '' == 'delivered') {
            $order->payment_status = 'paid';
            $order->update();
        }

        return response()->json([
                    'status' => true,
                    'message' => 'Order updated',
                    'data' => Order::where(['id' => $order->id])->with(['items', 'status', 'restorant', 'client', 'address'])->get(),
        ]);
    }

    public function updateOrderLocation(Order $order, $lat, $lng) {
        //Only assigned driver
        if (auth()->user()->id == $order->driver_id) {
            if ($order->status->pluck('alias')->last() == 'picked_up') {
                $order->lat = $lat;
                $order->lng = $lng;
                $order->update();

                return response()->json([
                            'status' => true,
                            'message' => 'Order lat/lng updated',
                ]);
            } else {
                return response()->json([
                            'status' => false,
                            'message' => 'Order is not is status where should change lat / lng',
                ]);
            }
        } else {
            return response()->json([
                        'status' => false,
                        'message' => 'Order not on this driver',
                        'data' => Order::where(['id' => $order->id])->with(['items', 'status', 'restorant', 'client', 'address'])->get(),
            ]);
        }
    }

    public function driverlocations() {

        //TODO - Method for admin onlt
        if (!auth()->user()->hasRole('admin')) {
            dd('Not allowed');
        }

        //1. Get all the working drivers, where active and working
        $theQuery = User::with([
                    'driverorders' => function ($query) {
                        $query->where('orders.payment_status', '!=', 'paid');
                    },
                    'driverorders.restorant', 'driverorders.laststatus', 'driverorders.address',])
                ->with('paths')
                ->role('driver')
                ->where(['active' => 1, 'working' => 1]);

        $toRespond = [
            'drivers' => $theQuery->get(),
        ];

        return response()->json($toRespond);
    }

    public function goOffline() {
        auth()->user()->working = 0;
        auth()->user()->update();

        return response()->json([
                    'status' => true,
                    'working' => 0,
                    'message' => 'Drver now offlline',
        ]);
    }

    public function goOnline() {
        auth()->user()->working = 1;
        auth()->user()->update();

        return response()->json([
                    'status' => true,
                    'working' => 1,
                    'message' => 'Drver now online',
        ]);
    }

    public function acceptOrder(Order $order) {
        //This driver decides to accept the order
        //Only assigned driver
        if (auth()->user()->id == $order->driver_id) {

            //1. Order will be accepted
            $order->status()->attach([13 => ['comment' => 'Driver accepts order', 'user_id' => auth()->user()->id]]);

            return response()->json([
                        'status' => true,
                        'message' => 'Order is accepted.',
            ]);
        } else {
            return response()->json([
                        'status' => false,
                        'message' => 'Order not on this driver',
            ]);
        }
    }

    public function rejectOrder(Order $order) {
        //This driver decides to reject the order
        //Only assigned driver
        if (auth()->user()->id == $order->driver_id) {

            //1. Order will be rejected
            $order->driver_id = null;
            $order->status()->attach([12 => ['comment' => 'Driver reject order', 'user_id' => auth()->user()->id]]);
            $order->update();

            //2. TODO Look for new driver
            //3. Update driver acceptence status
            auth()->user()->rejectedorders = auth()->user()->rejectedorders + 1;
            auth()->user()->update();

            return response()->json([
                        'status' => true,
                        'message' => 'Order is rejected.',
            ]);
        } else {
            return response()->json([
                        'status' => false,
                        'message' => 'Order not on this driver',
            ]);
        }
    }

}
