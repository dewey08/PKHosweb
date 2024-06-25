<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\support\Facades\Http;
use Illuminate\Contracts\Auth\MustVerifyEmail; 
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class A_ct_item_check extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'a_ct_item_check'; 
    protected $primaryKey = 'a_ct_item_check_id';
    protected $fillable = [ 
        'hn', 
        'cid', 
    ];
    // public $timestamps = false; 

  
}
