<?php

namespace App\Models;
use  App\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestorantHasDrivers extends Model
{
    use HasFactory;
    
    protected $table= 'restorant_has_drivers';
    protected $fillable = ['restorant_id','driver_id' ];
    
      public function restorant()
    {
        return User::find($this->restorant_id);
    }
    
      public function driver()
    {
        return User::find($this->driver_id);
    }

    
    
    
}
