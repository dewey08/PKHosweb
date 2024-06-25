<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Warehouse_stock extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'warehouse_stock';
    protected $primaryKey = 'warehouse_stock_id';
    protected $fillable = [
        'warehouse_inven_id',
        'warehouse_inven_name',
        'product_id'
         
    ];

  
}
