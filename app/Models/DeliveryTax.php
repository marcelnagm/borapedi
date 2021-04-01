<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryTax extends Model
{
    use HasFactory;
    
    protected $table= 'delivery_tax';
    protected $fillable = ['restaurant_id','distance','cost' ];
    
}
