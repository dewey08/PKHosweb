<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Market_basket_bill extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'market_basket_bill';
    protected $primaryKey = 'bill_id';
    protected $fillable = [
        'bill_no',
        'bill_date',
        'bill_user_id',
        'bill_user_name',
        'bill_status',
        'store_id'  
    ];

  
}
