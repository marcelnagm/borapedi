<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Restorant;

class FidelityProgram extends Model
{
    use HasFactory;
    
    protected $table= 'fidelity_program';
    protected $fillable = ['restaurant_id' ,'active','type_target','target_orders','target_value','type_reward','reward','type_coupon','active_from','active_to'];
    
      public function restorant()
    {
        return Restorant::find($this->restaurant_id);
    }
    
    public function getDateActive(){
         $dateActive = false;

        if ((new Carbon($this->active_to))->gt(new Carbon($this->active_from)) && Carbon::now()->between(new Carbon($this->active_from), new Carbon($this->active_to))) {
            $dateActive = true;
        } elseif ((new Carbon($this->active_from))->eq(new Carbon($this->active_to)) && (new Carbon(Carbon::now()->toDateString()))->eq(new Carbon($this->active_from)) && (new Carbon(Carbon::now()->toDateString()))->eq(new Carbon($this->active_to))) {
            $dateActive = true;
        }
        return $dateActive;
    }
    
    
    public function getActive(){
        return $this->active == 1 ? true : false;
    }
    
    
    
}
