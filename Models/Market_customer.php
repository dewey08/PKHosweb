<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Market_customer extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'market_customer';
    protected $primaryKey = 'customer_id';
    protected $fillable = [
        'customer_pname',
        'pcustomer_fname',
        'pcustomer_lname',
        'pcustomer_tel',
        'pcustomer_address',
        'pcustomer_email',
        'pcustomer_code', 
    ];

  
}
