<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class D_homeward_main extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'd_homeward_main';
    protected $primaryKey = 'd_homeward_main_id';
    protected $fillable = [
        'vn',
        'an',
        'pttype'         
    ];
 
}
