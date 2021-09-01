<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Restorant;

class Coupons extends Model
{
    protected $table = 'coupons';

    protected $fillable = [
        'name', 'code', 'restaurant_id', 'type', 'price', 'active_from', 'active_to', 'limit_to_num_uses','client_id'
    ];
    
    public function __toString() {
        return $this->type  == 0 ? "R$".$this->price : $this->price.'%';
    }
    
    public function client(){
        
        return $this->client_id != null ?  User::find($this->client_id) : null;
    }
    
    
    public function restaurant(){
        return $this->restorant();
    }
    
    public function restorant()
    {
        return Restorant::find($this->restaurant_id);
    }
    
    public function isExpired(){
        $date1=date_create("now");
          $date2=date_create($this->active_to);

        if($date2 <= $date1) return "EXPIRADO";
          
    $diff=date_diff($date1,$date2);
    return  $diff->format("%a");
    }
    
}
