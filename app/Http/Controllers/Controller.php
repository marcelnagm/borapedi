<?php

namespace App\Http\Controllers;

use App\Restorant;
use App\Models\DeliveryTax;
use Spatie\Geocoder\Geocoder;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Str;
use Image;
use Carbon\Carbon;

class Controller extends BaseController {

    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests;

    /**
     * @param {String} folder
     * @param {Object} laravel_image_resource, the resource
     * @param {Array} versinos
     */
    public function saveImageVersions($folder, $laravel_image_resource, $versions) {
        //Make UUID
        $uuid = Str::uuid()->toString();

        //Make the versions
        foreach ($versions as $key => $version) {
            if (isset($version['w']) && isset($version['h'])) {
                $img = Image::make($laravel_image_resource->getRealPath())->fit($version['w'], $version['h']);
                $img->save(public_path($folder) . $uuid . '_' . $version['name'] . '.' . 'jpg');
            } else {
                //Original image
                $laravel_image_resource->move(public_path($folder), $uuid . '_' . $version['name'] . '.' . 'jpg');
            }
        }

        return $uuid;
    }

    private function withinArea($point, $polygon, $n) {
        if ($polygon[0] != $polygon[$n - 1]) {
            $polygon[$n] = $polygon[0];
        }
        $j = 0;
        $oddNodes = false;
        $x = $point->lng;
        $y = $point->lat;
        for ($i = 0; $i < $n; $i++) {
            $j++;
            if ($j == $n) {
                $j = 0;
            }
            if ((($polygon[$i]->lat < $y) && ($polygon[$j]->lat >= $y)) || (($polygon[$j]->lat < $y) && ($polygon[$i]->lat >= $y))) {
                if ($polygon[$i]->lng + ($y - $polygon[$i]->lat) / ($polygon[$j]->lat - $polygon[$i]->lat) * ($polygon[$j]->lng - $polygon[$i]->lng) < $x) {
                    $oddNodes = !$oddNodes;
                }
            }
        }

        return $oddNodes;
    }

    public function calculateDistance($latitude1, $longitude1, $latitude2, $longitude2, $unit) {
        $theta = $longitude1 - $longitude2;
        $distance = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
        $distance = acos($distance);
        $distance = rad2deg($distance);
        $distance = $distance * 60 * 1.1515;
        switch ($unit) {
            case 'Mi':
                break;
            case 'K':
                $distance = $distance * 1.609344;
        }

        return round($distance, 2);
    }

    public function getAccessibleAddresses($restaurant, $addressesRaw) {
        $addresses = [];        
        $numItems = $restaurant->radius ? count($restaurant->radius) : 0;
        $max = DeliveryTax::where('restaurant_id', $restaurant->id)->max('distance');
//        $client = new \GuzzleHttp\Client();
//        $geocoder = new Geocoder($client);
//        $geocoder->setApiKey(config('settings.google_maps_api_key'));
//        $rid = $geocoder->getCoordinatesForAddress($restaurant->address);
        $rid = $restaurant->address;
        
        if ($addressesRaw) {
            foreach ($addressesRaw as $address) {
                $point = json_decode('{"lat": ' . $address->lat . ', "lng":' . $address->lng . '}');

                $rangeFound = false;
                if (!array_key_exists($address->id, $addresses)) {
                    $new_obj = (object) [];
                    $new_obj->id = $address->id;
                    $new_obj->address = $address->address;
                    $new_obj->nick= $address->nick;

                    $data2 = $this->getDrivingDistancePlain($address->address, $rid);
                   
                    if ($data2['distance'] > $max) {
                        $new_obj->inRadius = false;
                        $new_obj->rangeFound = false;
                         $new_obj->cost_total = 500;
                    } else {
                        $new_obj->inRadius = true;
                        $new_obj->rangeFound = true;
                        $tax = DeliveryTax::
                                where('restaurant_id', $restaurant->id)->
                                where('distance', '>=', $data2['distance'])
                                ->min('cost');

//                        $new_obj->cost_per_km = config('global.delivery');
                        $new_obj->cost_total = $tax;
                    }


                    $addresses[$address->id] = (object) $new_obj;
                }
            }
        }

//        dd($addresses);
        return $addresses;
    }

    private function getDrivingDistancePlain($add1, $add2) {
       $api = config('settings.google_maps_api_key');
        $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=`" .urlencode ($add1). "`&destinations=`" . urlencode ($add2) . "`&mode=driving&language=pl-PL&key=" . $api;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
//        dd ($url,$response);
        curl_close($ch);
        $response_a = json_decode($response, true);
//        dd($response_a0 );
        $dist = $response_a['rows'][0]['elements'][0]['distance']['value'];
        $time = $response_a['rows'][0]['elements'][0]['duration']['text'];

        return array('distance' => $dist/1000, 'time' => $time);   
    }
    
    private function getDrivingDistance($lat1, $lat2, $long1, $long2) {
//        dd ($lat1, $lat2, $long1, $long2);
        $api = config('settings.google_maps_api_key');
        $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=" . $lat1 . "," . $long1 . "&destinations=" . $lat2 . "," . $long2 . "&mode=driving&language=pl-PL&key=" . $api;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
//        dd ($url,$response);
        curl_close($ch);
        $response_a = json_decode($response, true);
//        dd($response_a0 );
        $dist = $response_a['rows'][0]['elements'][0]['distance']['value'];
        $time = $response_a['rows'][0]['elements'][0]['duration']['text'];

        return array('distance' => $dist/1000, 'time' => $time);
    }

    public function adminOnly() {
          if (! auth()->user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }
    }
    public function getRestaurant() {
        if (!auth()->user()->hasRole('owner')) {
            return null;
        }

        //Get restaurant for currerntly logged in user
        return Restorant::where('user_id', auth()->user()->id)->first();
    }

    public function ownerOnly() {
        if (!auth()->user()->hasRole('owner')) {
            abort(403, 'Unauthorized action.');
        }
    }

    public function replace_spec_char($subject) {
        $char_map = array(
            "??" => "-", "??" => "-", "??" => "-", "??" => "-",
            "??" => "A", "??" => "A", "??" => "A", "??" => "A", "??" => "A", "??" => "A", "??" => "A", "??" => "A", "??" => "A", "??" => "A", "??" => "A", "??" => "A", "??" => "A",
            "??" => "B", "??" => "B", "??" => "B",
            "??" => "C", "??" => "C", "??" => "C", "??" => "C", "??" => "C", "??" => "C", "??" => "C", "??" => "C", "??" => "C",
            "??" => "D", "??" => "D", "??" => "D", "??" => "D", "??" => "D",
            "??" => "E", "??" => "E", "??" => "E", "??" => "E", "??" => "E", "??" => "E", "??" => "E", "??" => "E", "??" => "E", "??" => "E", "??" => "E", "??" => "E", "??" => "E",
            "??" => "F", "??" => "F",
            "??" => "G", "??" => "G", "??" => "G", "??" => "G", "??" => "G", "??" => "G", "??" => "G",
            "??" => "H", "??" => "H", "??" => "H", "??" => "H", "??" => "H",
            "I" => "I", "??" => "I", "??" => "I", "??" => "I", "??" => "I", "??" => "I", "??" => "I", "I" => "I", "??" => "I", "??" => "I", "??" => "I", "??" => "I", "??" => "I", "??" => "I", "??" => "I",
            "??" => "J", "??" => "J",
            "??" => "K", "??" => "K", "??" => "K", "??" => "K", "??" => "K",
            "??" => "L", "??" => "L", "??" => "L", "??" => "L", "??" => "L", "??" => "L", "??" => "L",
            "??" => "M", "??" => "M", "??" => "M",
            "??" => "N", "??" => "N", "??" => "N", "??" => "N", "??" => "N", "??" => "N", "??" => "N", "??" => "N", "??" => "N",
            "??" => "O", "??" => "O", "??" => "O", "??" => "O", "??" => "O", "??" => "O", "??" => "O", "??" => "O", "??" => "O", "??" => "O", "??" => "O", "??" => "O",
            "??" => "P", "??" => "P", "??" => "P",
            "??" => "Q",
            "??" => "R", "??" => "R", "??" => "R", "??" => "R", "??" => "R", "??" => "R",
            "??" => "S", "??" => "S", "??" => "S", "??" => "S", "??" => "S", "??" => "S", "??" => "S",
            "??" => "T", "??" => "T", "??" => "T", "??" => "T", "??" => "T", "??" => "T", "??" => "T",
            "??" => "U", "??" => "U", "??" => "U", "??" => "U", "??" => "U", "??" => "U", "??" => "U", "??" => "U", "??" => "U", "??" => "U", "??" => "U", "??" => "U", "??" => "U", "??" => "U", "??" => "U", "??" => "U",
            "??" => "V", "??" => "V",
            "??" => "Y", "??" => "Y", "??" => "Y", "??" => "Y",
            "??" => "Z", "??" => "Z", "??" => "Z", "??" => "Z", "??" => "Z",
            "??" => "a", "??" => "a", "??" => "a", "??" => "a", "??" => "a", "??" => "a", "??" => "a", "??" => "a", "??" => "a", "??" => "a", "??" => "a", "??" => "a", "??" => "a",
            "??" => "b", "??" => "b", "??" => "b",
            "??" => "c", "??" => "c", "??" => "c", "??" => "c", "??" => "c", "??" => "c", "??" => "c", "??" => "c", "??" => "c",
            "??" => "ch", "??" => "ch",
            "??" => "d", "??" => "d", "??" => "d", "??" => "d", "??" => "d",
            "??" => "e", "??" => "e", "??" => "e", "??" => "e", "??" => "e", "??" => "e", "??" => "e", "??" => "e", "??" => "e", "??" => "e", "??" => "e", "??" => "e", "??" => "e",
            "??" => "f", "??" => "f",
            "??" => "g", "??" => "g", "??" => "g", "??" => "g", "??" => "g", "??" => "g", "??" => "g",
            "??" => "h", "??" => "h", "??" => "h", "??" => "h", "??" => "h",
            "i" => "i", "??" => "i", "??" => "i", "??" => "i", "??" => "i", "??" => "i", "??" => "i", "??" => "i", "??" => "i", "??" => "i", "??" => "i", "??" => "i", "??" => "i", "??" => "i", "??" => "i",
            "??" => "j", "??" => "j", "??" => "j", "??" => "j",
            "??" => "k", "??" => "k", "??" => "k", "??" => "k", "??" => "k",
            "??" => "l", "??" => "l", "??" => "l", "??" => "l", "??" => "l", "??" => "l", "??" => "l",
            "??" => "m", "??" => "m", "??" => "m",
            "??" => "n", "??" => "n", "??" => "n", "??" => "n", "??" => "n", "??" => "n", "??" => "n", "??" => "n", "??" => "n",
            "??" => "o", "??" => "o", "??" => "o", "??" => "o", "??" => "o", "??" => "o", "??" => "o", "??" => "o", "??" => "o", "??" => "o", "??" => "o", "??" => "o",
            "??" => "p", "??" => "p", "??" => "p",
            "??" => "q",
            "??" => "r", "??" => "r", "??" => "r", "??" => "r", "??" => "r", "??" => "r",
            "??" => "s", "??" => "s", "??" => "s", "??" => "s", "??" => "s", "??" => "s", "??" => "s",
            "??" => "t", "??" => "t", "??" => "t", "??" => "t", "??" => "t", "??" => "t", "??" => "t",
            "??" => "u", "??" => "u", "??" => "u", "??" => "u", "??" => "u", "??" => "u", "??" => "u", "??" => "u", "??" => "u", "??" => "u", "??" => "u", "??" => "u", "??" => "u", "??" => "u", "??" => "u", "??" => "u",
            "??" => "v", "??" => "v",
            "??" => "y", "??" => "y", "??" => "y", "??" => "y",
            "??" => "z", "??" => "z", "??" => "z", "??" => "z", "??" => "z", "??" => "z",
            "???" => "tm",
            "@" => "at",
            "??" => "ae", "??" => "ae", "??" => "ae", "??" => "ae", "??" => "ae",
            "??" => "ij", "??" => "ij",
            "??" => "ja", "??" => "ja",
            "??" => "je", "??" => "je",
            "??" => "jo", "??" => "jo",
            "??" => "ju", "??" => "ju",
            "??" => "oe", "??" => "oe", "??" => "oe", "??" => "oe",
            "??" => "sch", "??" => "sch",
            "??" => "sh", "??" => "sh",
            "??" => "ss",
            "??" => "ue",
            "??" => "zh", "??" => "zh",
        );
        return strtr($subject, $char_map);
    }

    public function makeAlias($name) {
        $name = $this->replace_spec_char($name);
        $name = str_replace(" ", "-", $name);
        return strtolower(preg_replace('/[^A-Za-z0-9-]/', '', $name));
    }

    public function scopeIsWithinMaxDistance($query, $latitude, $longitude, $radius = 25, $table = 'restorants') {
        $haversine = "(6371 * acos(cos(radians($latitude))
                        * cos(radians(" . $table . '.lat))
                        * cos(radians(' . $table . ".lng)
                        - radians($longitude))
                        + sin(radians($latitude))
                        * sin(radians(" . $table . '.lat))))';

        return $query
                        ->select(['name', 'id']) //pick the columns you want here.
                        ->selectRaw("{$haversine} AS distance")
                        ->whereRaw("{$haversine} < ?", [$radius])
                        ->orderBy('distance');
    }

 private $days = array(
    0 => 'monday',
    1 => 'tuesday',
    2 => 'wednesday',
    3 => 'thursday',
    4 => 'friday',
    5 => 'saturday',
    6 => 'sunday'
);
    
    public function getTimieSlots($hours) {
        $ourDateOfWeek = date('N') - 1;
        $business = $hours->getBusinessHours();
        
        $part = explode("-", $business->forDay($this->days[$ourDateOfWeek ])->__toString());
        $restaurantOppeningTime = $this->getMinutes(date('G:i', strtotime($part[0])));
        $restaurantClosingTime = $this->getMinutes(date('G:i', strtotime($part[1])));
        //Interval
        $intervalInMinutes = config('settings.delivery_interval_in_minutes');

        //Generate thintervals from
        $currentTimeInMinutes = Carbon::now()->diffInMinutes(Carbon::today());
//        dd($part,$currentTimeInMinutes ,$restaurantOppeningTime,$restaurantClosingTime);
        
        $from = $currentTimeInMinutes > $restaurantOppeningTime ? $currentTimeInMinutes : $restaurantOppeningTime; //Workgin time of the restaurant or current time,
        //print_r('now: '.$from);
        //To have clear interval
        $missingInterval = $intervalInMinutes - ($from % $intervalInMinutes); //21
        //print_r('<br />missing: '.$missingInterval);
        //Time to prepare the order in minutes
        $timeToPrepare = config('settings.time_to_prepare_order_in_minutes'); //30
        //First interval
        $from += $timeToPrepare <= $missingInterval ? $missingInterval : ($intervalInMinutes - (($from + $timeToPrepare) % $intervalInMinutes)) + $timeToPrepare;

        //$from+=$missingInterval;
        //Generate thintervals to
        $to = $restaurantClosingTime; //Closing time of the restaurant or current time

        $timeElements = [];
        for ($i = $from; $i <= $to; $i += $intervalInMinutes) {
            array_push($timeElements, $i);
        }
        //print_r("<br />");
        //print_r($timeElements);

        $slots = [];
        for ($i = 0; $i < count($timeElements) - 1; $i++) {
            array_push($slots, [$timeElements[$i], $timeElements[$i + 1]]);
        }

        //print_r("<br />SLOTS");
        //print_r($slots);
        //INTERVALS TO TIME
        $formatedSlots = [];
        for ($i = 0; $i < count($slots); $i++) {
            $key = $slots[$i][0] . '_' . $slots[$i][1];
            $value = $this->minutesToHours($slots[$i][0]) . ' - ' . $this->minutesToHours($slots[$i][1]);
            $formatedSlots[$key] = $value;
            //array_push($formatedSlots,[$key=>$value]);
        }

        return $formatedSlots;
    }
    
    /* "0_from" => "09:00"
      "0_to" => "20:00"
      "1_from" => "09:00"
      "1_to" => "20:00"
      "2_from" => "09:00"
      "2_to" => "20:00"
      "3_from" => "09:00"
      "3_to" => "20:00"
      "4_from" => "09:00"
      "4_to" => "20:00"
      "5_from" => "09:00"
      "5_to" => "17:00"
      "6_from" => "09:00"
      "6_to" => "17:00" */

    /*
      "0_from" => "9:00 AM"
      "0_to" => "8:10 PM"
      "1_from" => "9:00 AM"
      "1_to" => "8:00 PM"
      "2_from" => "9:00 AM"
      "2_to" => "8:00 PM"
      "3_from" => "9:00 AM"
      "3_to" => "8:00 PM"
      "4_from" => "9:00 AM"
      "4_to" => "8:00 PM"
      "5_from" => "9:00 AM"
      "5_to" => "5:00 PM"
      "6_from" => "9:00 AM"
      "6_to" => "5:00 PM"
     */

    public function getMinutes($time) {
        $parts = explode(':', $time);

        return ((int) $parts[0]) * 60 + (int) $parts[1];
    }

    public function minutesToHours($numMun) {
        $h = (int) ($numMun / 60);
        $min = $numMun % 60;
        if ($min < 10) {
            $min = '0' . $min;
        }

        $time = $h . ':' . $min;
        if (config('settings.time_format') == 'AM/PM') {
            $time = date('g:i A', strtotime($time));
        }

        return $time;
    }

}
