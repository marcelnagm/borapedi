<?php

namespace App\Models;

use App\Items;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Extras extends Model
{
    use HasFactory;
    
    protected $table= 'extras';
    protected $fillable = ['item_id','price','name','extra_for_all_variants'];
        
    
}
