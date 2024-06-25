<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Carservice_signature extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'carservice_signature';
    protected $primaryKey = 'signature_id';
    protected $fillable = [
        'car_service_id', 
        'car_service_no', 
        'signature_name_usertext', 
        'signature_name_stafftext', 
        'signature_name_hntext',       
    ];

  
}
