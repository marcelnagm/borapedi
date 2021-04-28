<?php

namespace App\Models;

use App\Items;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderHasItems extends Model
{
    use HasFactory;
    
    protected $table= 'order_has_items';
    protected $fillable = ['order_id','item_id','qty','extras','vat','vatvalue','variant_price','variant_name' ];
    
    public function item(){
        return Items::find($this->item_id);
    }
    
    
}
