<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FidelityProgram extends Model
{
    use HasFactory;
    
    protected $table= 'fidelity_program';
    protected $fillable = ['restaurant_id' ,'active','description','target','reward','type'];
    
    public function restorant()
    {
        return $this->belongsTo(\App\Restorant::class);
    }
    
    public function getActive(){
        return $this->active == 1 ? true : false;
    }
    
}
