<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\support\Facades\Http;
use Illuminate\Contracts\Auth\MustVerifyEmail; 
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class A_ct extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'a_ct'; 
    // protected $primaryKey = 'a_ct_id';
    protected $fillable = [
        'vn', 
        'hn', 
        'cid',
        'vstdate', 
        'ptname', 
        'pttype', 
        'qty',
        'sum_price',
        'user_id' 
    ];
    // public $timestamps = false; 

  
}
