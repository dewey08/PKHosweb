<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Warehouse_recieve extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'warehouse_recieve';
    protected $primaryKey = 'warehouse_recieve_id';
    protected $fillable = [
        'warehouse_recieve_code',
        'warehouse_recieve_no_bill',
        'warehouse_recieve_po'

    ];


}
