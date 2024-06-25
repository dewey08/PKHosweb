<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\support\Facades\Http;
use Illuminate\Contracts\Auth\MustVerifyEmail; 
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Acc_stm_ti_total extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'acc_stm_ti_total'; 
    protected $fillable = [
        'acc_stm_ti_total_id',
        'repno', 
        'hn',
        'cid',
        'fullname', 
        'vstdate', 
        'sum_price_approve',
        'date_save',
        'vn',
        'active' 
    ];
    // public $timestamps = false; 

  
}
