<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Env_pond extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'env_pond';
    protected $primaryKey = 'pond_id';
    // public $timestamps = false;  
    protected $fillable = [
        'pond_name'
        // 'trash_set_unit'
              
    ];

  
}
