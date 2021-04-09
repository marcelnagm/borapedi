<?php

namespace App\Http\Controllers;

use App\Categories;
use App\City;
use App\Events\CallWaiter;
use App\Extras;
use App\Hours;
use App\Imports\RestoImport;
use App\Items;
use App\Models\LocalMenu;
use App\Models\Options;
use App\Notifications\RestaurantCreated;
use App\Notifications\WelcomeNotification;
use App\Plans;
use App\Restorant;
use App\Tables;
use App\User;
use App\Models\DeliveryTax;
use App\Traits\Fields;
use App\Traits\Modules;
use Artisan;
use Carbon\Carbon;
use DB;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
//use Intervention\Image\Image;
use Image;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Role;
use Spatie\Geocoder\Geocoder;

class DevileryTaxController extends Controller {

    use Fields;
    use Modules;

    protected $imagePath = 'uploads/restorants/';

    /**
     * Auth checker functin for the crud.
     */
    private function authChecker() {
        $this->ownerOnly();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        if (auth()->user()->hasRole('owner')) {
            $max = DeliveryTax::where('restaurant_id', auth()->user()->restorant->id)->max('distance');
//            dd(auth()->user()->restorant->lat,auth()->user()->restorant->lng);
            $client = new \GuzzleHttp\Client();
        $geocoder = new Geocoder($client);
        $geocoder->setApiKey(config('settings.google_maps_api_key'));
//        dd(config('geocoder.key'));AIzaSyD-GiCHD5S8naqNDsutKK2UXtAeb_bXBVA
        $me = $geocoder->getCoordinatesForAddress(auth()->user()->restorant->address);
//        dd($me);
            return view('deliverytax.index',
                    ['restorant' => Restorant::find(auth()->user()->restorant->id),
                        'max' => $max,
                        'lat' => $me['lat'],
                        'lng' => $me['lng'],
                        'taxes' => DeliveryTax::where('restaurant_id', auth()->user()->restorant->id)->orderBy('distance', 'ASC')->get()
            ]);
        } else {
            return redirect()->route('orders.index')->withStatus(__('No Access'));
        }
    }

    public function delete(Request $request) {
        if (auth()->user()->hasRole('owner')) {
            $requestData = $request->all();
            DeliveryTax::find($requestData['id'])->delete();
            $max = DeliveryTax::where('restaurant_id', auth()->user()->restorant->id)->max('distance');
            return view('deliverytax.list',
                    [
                        'max' => $max,
                        'taxes' => DeliveryTax::where('restaurant_id', auth()->user()->restorant->id)->orderBy('distance', 'ASC')->get()
            ]);
        } else {
            return redirect()->route('orders.index')->withStatus(__('No Access'));
        }
    }

    public function post(Request $request) {
        if (auth()->user()->hasRole('owner')) {
            $requestData = $request->all();
            
            DeliveryTax::create($requestData);
            $max = DeliveryTax::where('restaurant_id', auth()->user()->restorant->id)->max('distance');
            return view('deliverytax.list',
                    [
                        'max' => $max,
                        'taxes' => DeliveryTax::where('restaurant_id', auth()->user()->restorant->id)->orderBy('distance', 'ASC')->get()
            ]);
        } else {
            return redirect()->route('orders.index')->withStatus(__('No Access'));
        }
    }

    
    public function getCoordinatesForTax(Request $request) {
        $client = new \GuzzleHttp\Client();
        $geocoder = new Geocoder($client);
        $geocoder->setApiKey(config('settings.google_maps_api_key'));
//        dd(config('geocoder.key'));AIzaSyD-GiCHD5S8naqNDsutKK2UXtAeb_bXBVA
        $me = $geocoder->getCoordinatesForAddress($request->address);
        $rid = $geocoder->getCoordinatesForAddress($request->address_rid);
        
        $max = DeliveryTax::where('restaurant_id', $request->r_id)->max('distance');

//        dd($max);
        $data2 = $this->getDrivingDistance($me['lat'], $rid['lat'], $me['lng'], $rid['lng']);
        if ($data2['distance'] > $max)
            $data = ['status' => false,
                'message' => 'Infelizmente o restaurante não entrega não sua região'
            ];
        else {
            $tax = DeliveryTax::
                    where('restaurant_id', $request->r_id)->
                    where('distance','>=', $data2['distance'])                    
                    ->min('cost');
                        
                $data = ['status' => true,
                'tax' => number_format($tax, 2)
            ];
        }
        return response()->json($data);
    }

    private function getDrivingDistance($lat1, $lat2, $long1, $long2) {

        $api = config('settings.google_maps_api_key');
        $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=" . $lat1 . "," . $long1 . "&destinations=" . $lat2 . "," . $long2 . "&mode=driving&language=pl-PL&key=" . $api;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        $response_a = json_decode($response, true);
//        dd($response_a0 );
        $dist = $response_a['rows'][0]['elements'][0]['distance']['text'];
        $time = $response_a['rows'][0]['elements'][0]['duration']['text'];

        return array('distance' => $dist, 'time' => $time);
    }

}
