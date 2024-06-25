<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Fdh_aer extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $connection = 'mysql';
    protected $table = 'fdh_aer';
    protected $primaryKey = 'fdh_aer_id';
    protected $fillable = [
        'HN','AN','DATEOPD','AUTHAE','AEDATE','AETIME','AETYPE'    
    ];

  
}
