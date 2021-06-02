<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientRatings extends Model
{
    use HasFactory;
    
    protected $table= 'clients_ratings';
    protected $fillable = ['name','restaurant_id','period','val' ];
    
}
