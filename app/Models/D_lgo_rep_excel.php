<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\support\Facades\Http;
use Illuminate\Contracts\Auth\MustVerifyEmail; 
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class D_lgo_rep_excel extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'd_lgo_rep_excel';     
    protected $fillable = [
        'd_lgo_rep_excel_id',
        'rep_a',  
        'no_b', 
        'tranid_c',
        'hn_d', 
        'STMdoc',
        'active'
    ];
    // public $timestamps = false;   
}
