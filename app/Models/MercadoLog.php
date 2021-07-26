<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MercadoLog extends Model
{
    use HasFactory;
    
    protected $table= 'mercado_pago';
    protected $fillable = ['retorno' ,'processed'];
    
}
