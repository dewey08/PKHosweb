<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Ssop_dispenseditems extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $connection = 'mysql7';
    protected $table = 'ssop_dispenseditems';
    protected $primaryKey = 'ssop_dispenseditems_id';
    protected $fillable = [ 
        'DispID', 
        'PrdCat',  
        'HospDrgID',  
        'DrgID' 
    ];

  
}
