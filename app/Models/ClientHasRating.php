<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Restorant as Restaurant;
use App\Models\ClientRatings;

class ClientHasRating extends Model
{
    use HasFactory;
    
       protected $table= 'client_has_rating';
    protected $fillable = ['restaurant_id','client_id','rating_id','spent','orders'];
 
    public function restaurant() {
        return Restaurant::find($this->restaurant_id);
    }
    public function rating() {
        return ClientRatings::find($this->rating_id);
    }
    
}
