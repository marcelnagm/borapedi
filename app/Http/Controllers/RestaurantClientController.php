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

class RestaurantClientController extends Controller {

    use Fields;
    use Modules;

    

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
       
        return view('restaurant_client.index');
    }
    
    public function store(Request $request) {
         

        $request->validate([
            'name' => ['required', 'string', 'unique:restorants,name', 'max:255'],            
            'email' => ['required', 'string', 'email', 'unique:users,email', 'max:255'],
            'phone' => ['required', 'string', 'regex:/^([0-9\s\-\+\(\)]*)$/'],
        ]);
         //Create the user
//        dd($request);
        $generatedPassword = Str::random(10);
        $client = new User;
        $client->name = $request->name;
        $client->email = $request->email;
        $client->phone = $request->phone;
        $client->api_token = Str::random(80);

        $client->password = Hash::make($generatedPassword);
        $client->save();

        //Assign role
        $client->assignRole('client');
//        
//        dd($client);
         Auth::loginUsingId($client->id);
        return redirect()->route('cart.checkout.end');
//         return view('restaurant_client.index');
         
    }
    
    public function login(Request $request) {
        
        $request->validate([            
            'email' => ['required', 'string',  'max:255'],
            'phone' => ['required', 'string', 'regex:/^([0-9\s\-\+\(\)]*)$/'],
        ]);
         //Create the user
        $email = $request->email;
        $phone = $request->phone;
        
        $client= User::where('email',$email)->
                where('phone',$phone)->first();
//        dd($client);
        
         Auth::loginUsingId($client->id);
         return redirect()->route('cart.checkout.end');
    }

}
