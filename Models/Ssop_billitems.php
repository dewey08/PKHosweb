<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Ssop_billitems extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    
    protected $connection = 'mysql';
    protected $table = 'ssop_billitems';
    protected $primaryKey = 'ssop_billitems_id';
    protected $fillable = [  
        'Invno',  
        'SvDate',  
        'BillMuad',
        'LCCode', 
        'STDCode', 
        'Desc' 
    ];

  
}
