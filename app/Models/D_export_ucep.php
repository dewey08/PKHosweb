<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class D_export_ucep extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $connection = 'mysql3';
    protected $table = 'd_export_ucep';
    protected $primaryKey = 'd_export_ucep_id';
    protected $fillable = [
        'vn',
        'an',
        'hn'         
    ];

  
}
