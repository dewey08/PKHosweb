<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Checksit_hos extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    
    // protected $connection = 'mysql7';
    protected $table = 'checksit_hos';
    protected $primaryKey = 'checksit_hos_id';
    protected $fillable = [  
        'vn',
        'hn',  
        'cid', 
        'vstdate',
        'vsttime',
        'pttype',
        'ptname',
        'staff'
    ];

  
}
