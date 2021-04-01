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

class DevileryTaxController extends Controller
{
    use Fields;
    use Modules;
    
    protected $imagePath = 'uploads/restorants/';

    /**
     * Auth checker functin for the crud.
     */
    private function authChecker()
    {
        $this->ownerOnly();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->hasRole('owner')) {
//            return view('restorants.index', ['restorants' => $restaurants->where(['active'=>1])->paginate(10)]);
            return view('deliverytax.index',
                    ['restorant' => Restorant::find(auth()->user()->restorant->id),
                    'taxes' => DeliveryTax::where('restaurant_id',auth()->user()->restorant->id)->orderBy('distance', 'ASC')->get()
                    ]);
        } else {
            return redirect()->route('orders.index')->withStatus(__('No Access'));
        }
    }
    
    public function post(Request $request)
    {
        if (auth()->user()->hasRole('owner')) {
            $requestData = $request->all();
//        dd($requestData);
        DeliveryTax::create($requestData);
         return view('deliverytax.list',
                    [
                    'taxes' => DeliveryTax::where('restaurant_id',auth()->user()->restorant->id)->orderBy('distance', 'ASC')->get()
                    ]);
        } else {
            return redirect()->route('orders.index')->withStatus(__('No Access'));
        }
    }

}
