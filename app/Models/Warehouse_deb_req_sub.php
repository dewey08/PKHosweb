<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Warehouse_deb_req_sub extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'warehouse_deb_req_sub';
    protected $primaryKey = 'warehouse_deb_req_sub_id';
    protected $fillable = [
        'warehouse_deb_req_id',
        'warehouse_deb_req_code',
        'product_id'
         
    ];

  
}
