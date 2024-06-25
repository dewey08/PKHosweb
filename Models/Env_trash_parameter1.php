<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Env_trash_parameter extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'env_trash_type';
    protected $primaryKey = 'trash_type_id';
    // public $timestamps = false;  
    protected $fillable = [
        'trash_type_name',
        'trash_type_name_unit'
              
    ];

  
}
