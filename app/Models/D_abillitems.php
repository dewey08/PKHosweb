<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class D_abillitems extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    // protected $connection = 'mysql7';
    protected $table = 'd_abillitems';
    protected $primaryKey = 'd_abillitems_id';
    protected $fillable = [ 
        'AN', 
        'sequence',  
        'ServDate',   
    ];
    public $timestamps = false; 
  
}
