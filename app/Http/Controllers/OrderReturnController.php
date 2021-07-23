<?php

namespace App\Http\Controllers;

use App\Repositories\Orders\OrderRepoGenerator;
use App\Exports\OrdersExport;
use App\Notifications\OrderNotification;
use App\Order;
use App\Restorant;
use App\Status;
use App\User;
use App\WhatsappService as WhatsappService;
use App\Models\Variants;
use App\Models\Extras;
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
use MercadoPago\Preference;
use MercadoPago\Payer;
use MercadoPago\Payment;
use MercadoPago\Item;
use MercadoPago\SDK as SDK;

class OrderReturnController {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
//        $data = json_decode(file_get_contents('php://input'), true);
//        $input = $request->all();;  
        $data = json_decode(file_get_contents('php://input'), true);

//        dd ($data);
//        var_dump( $data);
//         MercadoPago\SDK::setAccessToken("ENV_ACCESS_TOKEN");
//
        if ($data["type"] == '"payment"') {
            if ($data['action'] == 'payment.updated') {
                $order = Order::find($data['data']['id']);
                $order->payment_status = 'Webhooks Up';
            }
            if ($data['action'] == 'payment.created') {
                $order->payment_status = 'Webhooks create';
            }
            $order->save();
            dd("ok");
        }
    }

}
