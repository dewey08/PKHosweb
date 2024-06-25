<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Products_request extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'products_request';
    protected $primaryKey = 'request_id';
    protected $fillable = [
        'request_code',
        'request_year',
        'request_date',
        'request_because_buy',
        'request_debsubsub_id',
        'request_debsubsub_name'      
        
    ];

  
}
