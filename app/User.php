<?php

namespace App;

use App\SmsVerification;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Spatie\Permission\Traits\HasRoles;
use Twilio\Rest\Client;
use App\Traits\HasConfig;
use App\Order;
use App\Coupons;
use App\Models\ClientHasRating;
use App\Models\FidelityProgram;
use App\Models\Reward;
use Akaunting\Module\Facade as Module;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    use HasRoles;
    use Billable;
    use HasConfig;

    protected $modelName="App\User";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'api_token', 'birth_date', 'working', 'lat', 'lng', 'numorders', 'rejectedorders','restaurant_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'api_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
    ];

    public function getAcceptanceratingAttribute()
    {
        if ($this->numorders == 0) {
            return 'No orders';
        } else {
            return round(((1 - ($this->rejectedorders / $this->numorders)) * 100), 2);
        }
    }

    public function getExtraMenus(){
        $menus=[];
        if($this->hasRole('admin')){

        }else if($this->hasRole('owner')){
            foreach (Module::all() as $key => $module) {
                if(is_array($module->get('ownermenus'))){
                    foreach ($module->get('ownermenus') as $key => $menu) {
                       array_push($menus,$menu);
                    }
                }
            }
        }
        return $menus;
    }

    public function restorant()
    {
        return $this->hasOne(\App\Restorant::class);
    }

    public function restaurant()
    {
        return $this->hasOne(\App\Restorant::class,'id','restaurant_id');
    }

    

    public function plan()
    {
        return $this->hasOne(\App\Plans::class, 'id', 'plan_id');
    }

    public function mplanid()
    {
        return $this->plan_id ? $this->plan_id : intval(config('settings.free_pricing_id'));
    }

    public function addresses()
    {
        return $this->hasMany(\App\Address::class)->where(['address.active' => 1]);
    }

    public function paths()
    {
        return $this->hasMany(\App\Paths::class, 'user_id', 'id')->where('created_at', '>=', Carbon::now()->subHours(2));
    }

    public function orders()
    {
        return $this->hasMany(\App\Order::class, 'client_id', 'id');
    }

    public function driverorders()
    {
        return $this->hasMany(\App\Order::class, 'driver_id', 'id');
    }

    public function routeNotificationForOneSignal()
    {
        return ['include_external_user_ids' => [$this->id.'']];
    }

    public function routeNotificationForTwilio()
    {
        return $this->phone;
    }

    public function hasVerifiedPhone()
    {
        return ! is_null($this->phone_verified_at);
    }

    public function markPhoneAsVerified()
    {
        return $this->forceFill([
            'phone_verified_at' => $this->freshTimestamp(),
        ])->save();
    }

    public function callToVerify()
    {
        $code = random_int(100000, 999999);
        $this->forceFill(['verification_code' => $code])->save();
        $client = new Client(config('settings.twilio_sid'), config('settings.twilio_auth_token'));
        $body = __('Hi').' '.$this->name.".\n\n".__('Your verification code is').': '.$code;
        $client->messages->create($this->phone, ['from' => config('settings.twilio_from'), 'body' => $body]);
    }
    
    public function getFormmatedPhone(){
        $client_phone = $this->phone;
        $client_phone = str_replace('-', '', str_replace(')', '', str_replace('(', '', $client_phone)));
        $client_phone = preg_replace('/\s+/', '', '55' . $client_phone);
        
return $client_phone;        
    }   
    /**
     *  default 6 monts
     * @param type $restorant_id
     * @return array com cont => quantos pedidos, total => valor total.
     */
    public function BuysByRestaurant($restorant_id,$months = 6,$value_min = 0)
    {
            $date = date('Y-m-d', strtotime(date('Y-m-d'). ' -  '.$months.' month'));
//            dd($date);
            $res = DB::select('SELECT count(client_id) as cont,sum(`order_price`) as total FROM `orders` WHERE `client_id` = '.auth()->user()->id.' and created_at >= "'.$date.'" and restorant_id = "'.$restorant_id.'" and order_price >= '.$value_min.' group by client_id');            
            
            if (count($res) >0){
            $res = json_decode(json_encode($res), true)[0];
            
            return $res;
            }else{
//                dd($res);
                return array('cont' => 0, 'total' => 0);
            }
                
    }
    
    public function client_has_rating()
    {
        return  ClientHasRating::
                where('client_id', '=', $this->id)->get();
           
    }
    public function coupons()
    {
        return  Coupons::
                where('client_id', '=', $this->id);
           
    }
    
    public function ClientHasRating($r_id)
    {
        $rat =  ClientHasRating::
                where('restaurant_id', '=', $r_id)
                ->where('client_id', '=', $this->id)->first();
        
        return $rat != null ? $rat->rating()->name: 'Nenhum' ;   
    }
    
    public function OrdersFromRestorant()
    {
        return  Order::select('orders.*')
                ->join('users', 'orders.client_id', '=', 'users.id')
                ->where('orders.restorant_id', '=', auth()->user()->restorant->id)
                ->where('users.id', '=', $this->id)->get();
           
    }
    
    public function fidelity_program(){
        
       return  FidelityProgram::where('active',1)
                ->whereRaw('restaurant_id in(select DISTINCT restorant_id from orders where client_id = '.$this->id.')');
    }
    public function fidelity_program_reward($id){
        
       return  Reward::where('program_id', $id)->
                                    where('client_id', auth()->user()->id)->
                                    count() == 1;
    }
    
}
