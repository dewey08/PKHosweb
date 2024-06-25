<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Warehouse_recieve_sub extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'warehouse_recieve_sub';
    protected $primaryKey = 'warehouse_recieve_sub_id';
    protected $fillable = [
        'warehouse_recieve_id',
        'warehouse_recieve_code',
        'product_id'

    ];


}
