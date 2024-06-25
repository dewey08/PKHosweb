<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Stm_import extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    
    protected $connection = 'mysql7';
    protected $table = 'stm_import';
    protected $primaryKey = 'stm_import_id';
    protected $fillable = [  
        'stm_head_id', 
        'hreg',  
        'hn',  
    ];

  
}
