<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\support\Facades\Http;
use Illuminate\Contracts\Auth\MustVerifyEmail; 
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Acc_stm_lgoti_excel extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'acc_stm_lgoti_excel'; 
    
    protected $fillable = [
        'acc_stm_lgoti_excel_id',
        'repno',  
        'hn', 
        'cid',
        'ptname', 
        'type',
        'vstdate'
    ];
    // public $timestamps = false;   
}
