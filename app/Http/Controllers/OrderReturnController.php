<?php

namespace App\Http\Controllers;

use App\Repositories\Orders\OrderRepoGenerator;
use App\Exports\OrdersExport;
use App\Notifications\OrderNotification;
use App\Order;
use App\Restorant;
use App\Models\MercadoLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Carbon;
use willvincent\Rateable\Rating;
use App\Services\ConfChanger;
use Akaunting\Module\Facade as Module;
use App\Events\OrderAcceptedByAdmin;
use App\Events\OrderAcceptedByVendor;
use MercadoPago\Payment;
use MercadoPago\Item;
use MercadoPago\SDK as SDK;
use Illuminate\Support\Facades\Storage;

class OrderReturnController {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function process(Request $request) {
        $orders = Order::where('payment_method', 'mercadopago')
                ->where('payment_status', '=', 'unpaid')
                ->get();
//        $orders = Order::where('id', 636)->get();
//        dd ($orders);
        foreach ($orders as $order) {
            $ch = curl_init();
            $url = "https://api.mercadopago.com/v1/payments/search?criteria=desc&external_reference=" . $order->id;

            $rest = Restorant::find($order->restorant_id);
            //GET THE KEY
            //System setup 
            $access_token = config('mercadopago.access_token', "");

            //Setup based on vendor
            if (config('mercadopago.useVendor')) {
                $access_token = $rest->getConfig('mercadopago_access_token', '');
            }

            curl_setopt($ch, CURLOPT_URL, $url);
            $headers = array(
                "Accept: application/json",
                "Authorization: Bearer " . $access_token,
            );



            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $server_output = curl_exec($ch);
            $data_server = json_decode($server_output, true);
            foreach ($data_server['results'] as $return) {
                if ($return['status'] == "approved") {
                    $order->payment_status = 'paid';
                    $order->save();
                     WhatsappService::ssendMessage($order,'paid');
                }
                
            }
            $now = strtotime("-5 minutes");
            $now6 = strtotime("-6 minutes");

            if ($now >= strtotime($order->created_at->toDateTimeString()) && 
               $now6 <= strtotime($order->created_at->toDateTimeString())       ) {
//                echo $now;
//                echo strtotime($order->created_at->toDateTimeString());
//                echo 'expired!';
                 WhatsappService::ssendMessage($order,'fail');
            }
//            dd($data_server);

            curl_close($ch);
        }
        dd("ok");
    }

    public function index(Request $request) {
        $input = file_get_contents('php://input');
        $mercado = new MercadoLog();
        $mercado->retorno = $input;
        $mercado->save();
    }

}
