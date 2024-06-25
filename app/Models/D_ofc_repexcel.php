<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class D_ofc_repexcel extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'd_ofc_repexcel';
    protected $primaryKey = 'd_ofc_repexcel_id';
    protected $fillable = [
        'a',
        'b',
        'c'         
    ];

  
}
