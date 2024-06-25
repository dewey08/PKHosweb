<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Fdh_mini_dataset extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'fdh_mini_dataset';
    protected $primaryKey = 'fdh_mini_dataset_id';
    protected $fillable = [
        'service_date_time',
        'hcode',
        'total_amout'         
    ];

  
}
