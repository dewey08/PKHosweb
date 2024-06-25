<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Market_product_rep extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'market_product_rep';
    protected $primaryKey = 'request_id';
    protected $fillable = [
        'request_code',
        'request_no_bill',
        'request_year',
        'request_date', 
      
    ];

  
}
