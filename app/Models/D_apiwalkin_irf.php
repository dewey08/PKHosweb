<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class D_apiwalkin_irf extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'd_apiwalkin_irf';
    protected $primaryKey = 'd_apiwalkin_irf_id';
    protected $fillable = [
        'blobName',
        'blobType',
        'blob'         
    ];

  
}
