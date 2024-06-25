<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Warehouse_deb_req extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'warehouse_deb_req';
    protected $primaryKey = 'warehouse_deb_req_id';
    protected $fillable = [
        'warehouse_deb_req_code',
        'warehouse_deb_req_year',
        'warehouse_deb_req_date'
         
    ];

  
}
