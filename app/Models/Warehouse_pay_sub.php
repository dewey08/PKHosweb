<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Warehouse_pay_sub extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'warehouse_pay_sub';
    protected $primaryKey = 'warehouse_pay_sub_id';
    protected $fillable = [
        'warehouse_pay_id',
        'product_id',
        'product_code'
         
    ];

  
}
